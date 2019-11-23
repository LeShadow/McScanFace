<?php

namespace App\Http\Controllers;

use App\Repositories\PreferencesRepositoryInterface;
use App\ScanFiles;
use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;
use Storage;
use Auth;
class ScanFilesController extends Controller
{
    protected $prefs;

    public function __construct(PreferencesRepositoryInterface $pref)
    {
        $this->prefs = $pref;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScanFiles  $scanFiles
     * @return \Illuminate\Http\Response
     */
    public function show(ScanFiles $scanFiles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScanFiles  $scanFiles
     * @return \Illuminate\Http\Response
     */
    public function edit(ScanFiles $scanFiles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScanFiles  $scanFiles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScanFiles $scanFiles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScanFiles  $scanFiles
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScanFiles $scanFiles)
    {
        //
    }

    public function export_to_es(Request $request)
    {
        $pref_arr = $this->prefs->findWhere(['user_id','=', Auth::user()->id]);
        $host = [
            $pref_arr[0]->es_endpoint
        ];
        // https://ki4lsax5j5:6m9my65lhv@mcscanface-9999619474.eu-west-1.bonsaisearch.net:443
        $client = \Elasticsearch\ClientBuilder::create()->setHosts($host)->build();
        $contents = Storage::disk('public')->get('results/results_1574353529.json');
        $obj_contents = json_decode($contents);

        $params = ['body' => []];
        //for($i = 0; $i < 100; $i++) {
        foreach($obj_contents as $obj)
        {
            $params['body'][] = [
                'index' => [
                    '_index' => 'scans',
                ]
            ];
            //dd($obj);
            $params['body'][] = $obj;
        }

        $response = $client->bulk($params);

    }
}
