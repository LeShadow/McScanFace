<?php

namespace App\Http\Controllers;

use App\Classes\SSHHelper;
use App\Repositories\ServerRepository;
use App\Repositories\ServerRepositoryInterface;
use App\Scan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\ScanRepositoryInterface;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use phpseclib\Crypt\RSA;
use Ramsey\Uuid\Uuid;
use Auth;
class ScanController extends Controller
{
    protected $scans;
    protected $servers;

    public function __construct(ScanRepositoryInterface $scan, ServerRepositoryInterface $server){
        $this->scans = $scan;
        $this->servers = $server;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        return view('scans.overview', [ 'scans' => $this->scans->findWhere(['user_id','=',Auth::user()->id])]);
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
     * @param  \Illuminate\Http\Request  $request
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
            'name'    => 'required|string:255',
            'ip_ranges' => 'required|string'
        ]);

        $v->sometimes('ports', 'required|string', function($input){
            return $input->top_ports == 0;
        });

        $v->sometimes('top_ports', 'required|integer', function($input){
            return strlen($input->ports) == 0;
        });

        if ($v->fails()) {
            return redirect()
                ->route('get_create_scan')
                ->withErrors($v)
                ->withInput();
        }

        $data_array = [
            'name'          => $request->name,
            'output_format' => $request->output_format,
            'banners'       => ($request->has('banners'))? 1:0,
            'rate'          => $request->rate,
            'ip_ranges'     => $request->ip_ranges,
        ];


        if(!empty($request->top_ports))
        {
            $data_array['top_ports'] = $request->top_ports;
        }
        else
        {
            $data_array['ports'] = $request->ports;
        }

        $scan_create = $this->scans->create($data_array);

        if($scan_create) {
            $request->session()->flash('scan_success', 'Added scan <b>' . $request->name . '</b> successfully.');
        }
        else{
            $request->session()->flash('scan_error', 'Something went wrong while adding: <b>' . $request->name . '</b>.');
        }

        return redirect()->route('scan_overview');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Scan  $scan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return view('scans.detail', ['scan' => $this->scans->find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Scan  $scan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return view('scans.edit', [ 'scans' => $this->scans->find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Scan  $scan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scan $scan)
    {
        //
    }

    public function start(Request $request)
    {
        //Artisan::call('checkserverstatus');

        $scan_servers = $this->servers->findWhere([['status','=','1'], ['masscan_install_status', '=', '1'], ['scan_id', '=', '0']]);
        $scan = $this->scans->findWhere(['id', '=', $request->id]);
        if($scan_servers->count() === 0)
        {
            $request->session()->flash('scan_error', 'There are no servers online for the following scan: <b>' . $scan[0]->name . '</b>.');
            return redirect()->route('scan_overview');
        }

        //
        // Build command: masscan ipranges -pports --rate rates --output-format outputformat --output_filename filename.output_format
        //

        $scan_command = "screen -dmS masscan_scan masscan " .
            $scan[0]->ip_ranges . " -p" .
            $scan[0]->ports . " " .
            (($scan[0]->top_ports !== NULL)?" --top-ports " .
                $scan[0]->top_ports:"") . " --rate " .
            $scan[0]->rate . " --output-format " .
            $scan[0]->output_format . " --output_filename " .
            $scan[0]->id . "_" .
            $scan[0]->name . "." .
            $scan[0]->output_format . " " .
            (($scan[0]->banners === 1)? "--banners":"") . "";

        //dd($scan_command);
        if($scan_servers->count() === 1)
        {
            $server_connection = new SSHHelper($scan_servers[0]->uuid, $scan_servers[0]->user, $scan_servers[0]->ip, $scan_servers[0]->port, $scan_servers[0]->public_key, $scan_servers[0]->private_key);
            $this->scans->update($scan[0]->id, ['scan_status' => 1]);
            $this->servers->update($scan_servers[0]->id, ['scan_id' => $scan[0]->id]);
            $server_connection->command($scan_command);
            $request->session()->flash('scan_success', 'Scan started: <b>' . $scan[0]->name . '</b>.');
            return redirect()->route('scan_overview');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Scan  $scan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scan $scan)
    {
        //
    }
}
