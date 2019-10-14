<?php

namespace App\Http\Controllers;

use App\Server;
use App\Http\Requests\StoreServerRequest;
use Illuminate\Http\Request;
use App\Repositories\ServerRepositoryInterface;
use PHPUnit\Framework\Constraint\IsEmpty;

class ServerController extends Controller
{
    protected $servers;
    public function __construct(){
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
    public function store(StoreServerRequest $request)
    {
        //
        if(!IsEmpty($request->input('ip'))){
            return $this->servers->create([
                'ip'      => $request->ip,
                'port'    => $request->port,
                'passkey' => $request->passkey,
                'user'    => $request->user,
                'name'    => $request->name,
            ]);
        }
        else{
            return view('servers.create');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function show(Server $server)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function edit(Server $server)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Server $server)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function destroy(Server $server)
    {
        //
    }
}
