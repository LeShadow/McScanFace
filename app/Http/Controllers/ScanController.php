<?php
namespace App\Http\Controllers;

use App\Classes\SSHHelper;
use App\Repositories\ScanFilesRepositoryInterface;
use App\Repositories\ServerRepository;
use App\Repositories\ServerRepositoryInterface;
use App\Scan;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\ScanRepositoryInterface;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use phpseclib\Crypt\RSA;
use Ramsey\Uuid\Uuid;
use Auth;
use Storage;
use \stdClass;
use Illuminate\Support\Facades\Log;
define('NET_SSH2_LOGGING', 2);
class ScanController extends Controller
{
    protected $scans;
    protected $servers;
    protected $scan_files;

    public function __construct(ScanRepositoryInterface $scan, ServerRepositoryInterface $server, ScanFilesRepositoryInterface $scan_file)
    {
        $this->scans = $scan;
        $this->servers = $server;
        $this->scan_files = $scan_file;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        return view('scans.overview', ['scans' => $this->scans->findWhere(['user_id', '=', Auth::user()->id])]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('scans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request);

        $v = Validator::make($request->all(), [
            'output_format' => 'required|string',
            //'banners' => 'boolean',
            'rate' => 'required|integer',
            'name' => 'required|string:255',
            'ip_ranges' => 'required|string'
        ]);

        $v->sometimes('ports', 'required|string', function ($input) {
            return $input->top_ports == 0;
        });

        $v->sometimes('top_ports', 'required|integer', function ($input) {
            return strlen($input->ports) == 0;
        });

        if ($v->fails()) {
            return redirect()
                ->route('get_create_scan')
                ->withErrors($v)
                ->withInput();
        }

        $data_array = [
            'name' => $request->name,
            'output_format' => $request->output_format,
            'banners' => ($request->has('banners')) ? 1 : 0,
            'rate' => $request->rate,
            'ip_ranges' => $request->ip_ranges,
        ];


        if (!empty($request->top_ports)) {
            $data_array['top_ports'] = $request->top_ports;
        } else {
            $data_array['ports'] = $request->ports;
        }

        $scan_create = $this->scans->create($data_array);

        if ($scan_create) {
            $request->session()->flash('scan_success', 'Added scan <b>' . $request->name . '</b> successfully.');
        } else {
            $request->session()->flash('scan_error', 'Something went wrong while adding: <b>' . $request->name . '</b>.');
        }

        return redirect()->route('scan_overview');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Scan $scan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return view('scans.detail', ['scan' => $this->scans->find($id), 'files' => $this->scan_files->findWhere(['scan_id', '=', $id])]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Scan $scan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return view('scans.edit', ['scans' => $this->scans->find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Scan $scan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scan $scan)
    {
        //
    }

    public function start(Request $request)
    {
        //Artisan::call('checkserverstatus');

        $scan_servers = $this->servers->findWhere([['status', '=', '1'], ['masscan_install_status', '=', '1'], ['scan_id', '=', '0']]);
        $scan = $this->scans->findWhere(['id', '=', $request->id]);
        if ($scan_servers->count() === 0) {
            $request->session()->flash('scan_error', 'There are no servers online for the following scan: <b>' . $scan[0]->name . '</b>.');
            return redirect()->route('scan_overview');
        }

        //
        // Build command: masscan ipranges -pports --rate rates --output-format outputformat --output_filename filename.output_format
        //

        $scan_command = "screen -dmS masscan_scan masscan " .
            str_replace("\n", ",", $scan[0]->ip_ranges) . " -p" .
            $scan[0]->ports . " " .
            (($scan[0]->top_ports !== NULL) ? " --top-ports " .
                $scan[0]->top_ports : "") . " --rate " .
            $scan[0]->rate . " --output-format " .
            $scan[0]->output_format . " --output_filename " .
            $scan[0]->id . "_" .
            str_replace(' ', '_', $scan[0]->name) . "." .
            $scan[0]->output_format . " " .
            (($scan[0]->banners === 1) ? "--banners" : "") . " --source-port 61000";

        if ($scan_servers->count() === 1) {
            //dd('only one');
            $server_connection = new SSHHelper($scan_servers[0]->uuid, $scan_servers[0]->user, $scan_servers[0]->ip, $scan_servers[0]->port, $scan_servers[0]->public_key, $scan_servers[0]->private_key);
            $this->scans->update($scan[0]->id, ['scan_status' => 1]);
            $this->servers->update($scan_servers[0]->id, ['scan_id' => $scan[0]->id]);
            $server_connection->command($scan_command);
            $request->session()->flash('scan_success', 'Scan started: <b>' . $scan[0]->name . '</b>.');
            return redirect()->route('scan_overview');
        }
        $count = 1;
        foreach ($scan_servers as $scan_server) {

            $server_connection = new SSHHelper($scan_server->uuid, $scan_server->user, $scan_server->ip, $scan_server->port, $scan_server->public_key, $scan_server->private_key);
            $this->scans->update($scan[0]->id, ['scan_status' => 1]);
            $this->servers->update($scan_server->id, ['scan_id' => $scan[0]->id]);
            Log::debug($scan_command . " --shards " . $count . "/" . $scan_servers->count());
            $res = $server_connection->command($scan_command . " --shards " . $count . "/" . $scan_servers->count());
            Log::debug($res);
            $count++;
        }
        $request->session()->flash('scan_success', 'Scan started: <b>' . $scan[0]->name . '</b>.');
        return redirect()->route('scan_overview');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Scan $scan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scan $scan)
    {
        //
    }

    public function get_results(Request $request)
    {
        Storage::disk('public')->makeDirectory('results');

        $scan = $this->scans->find($request->input('id'));

        if ($scan->scan_status < 2) {
            $request->session()->flash('scan_error', 'This scan is not finished yet.');
            return redirect()->route('scan_overview');
        }

        $servers = $this->servers->findWhere(['scan_id', '=', $request->input('id')]);
        if ($servers->count() === 0) {
            $request->session()->flash('scan_error', 'No servers found for this scan.');
            return redirect()->route('scan_overview');
        }

        $json_results = json_encode(new stdClass);

        foreach ($servers as $server) {
            $ssh = new SSHHelper($server->uuid, $server->user, $server->ip, $server->port, $server->public_key, $server->private_key, 'SFTP');
            $result_data = $ssh->read_file($request->input('id') . '_'.str_replace(' ', '_', $scan->name).'.' . $scan->output_format);
            //'/' . $server->user . '/' .
            $processed_data = '[' . Str::replaceFirst(",\n{finished: 1}\n", ']', $result_data);
            $json_results = json_encode(array_merge(json_decode($json_results, true), json_decode($processed_data, true)));
        }

        $file_name = 'results_' . Carbon::now()->timestamp . '.json';
        if (Storage::disk('public')->put('results/' . $file_name, $json_results)) {
            $this->scan_files->create(['filename' => $file_name, 'hash' => hash_file('sha256', Storage::disk('public')->path('results/' . $file_name)), 'processed' => 0, 'scan_id' => $request->input('id')]);

            $this->scans->update($request->input('id'), ['scan_status' => 3]);
            foreach ($servers as $server) {
                $this->servers->update($server->id, ['scan_id' => 0]);
            }
            $request->session()->flash('scan_success', 'Scan succesfully processed. <b>You can download the files now</b>.');
            return redirect()->route('scan_overview');
        }

        $request->session()->flash('scan_error', 'Something went wrong while processing the results.');
        return redirect()->route('scan_overview');

    }
}
