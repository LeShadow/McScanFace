<?php

namespace App\Http\Controllers;

use Auth;
use App\Server;
use App\Http\Requests\StoreServerRequest;
use Illuminate\Http\Request;
use App\Repositories\ServerRepositoryInterface;
use PHPUnit\Framework\Constraint\IsEmpty;

class ServerController extends Controller
{
    protected $servers;
    public function __construct(ServerRepositoryInterface $server){
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
        return view('servers.overview', [ 'servers' => $this->servers->findWhere(['user_id','=',Auth::user()->id])]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('servers.create');
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
            return $this->servers->create([
                'ip'      => $request->ip,
                'port'    => $request->port,
                'passkey' => $request->passkey,
                'user'    => $request->user,
                'name'    => $request->name,
                'user_id' => Auth::user()->id,
            ]);

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
     * @param $id
     * @return void
     */
    public function edit($id)
    {
        //
        return view('servers.edit', [ 'servers' => $this->servers->find($id)]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return void
     */
    public function update(StoreServerRequest $request, $id)
    {
        //
        $server_update =  $this->servers->update($id,
            [
                'ip'      => $request->ip,
                'port'    => $request->port,
                'passkey' => $request->passkey,
                'user'    => $request->user,
                'name'    => $request->name,
                'user_id' => Auth::user()->id,
            ]);
        if($server_update === true)
        {
            return redirect()->route('server_overview');
        }
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
