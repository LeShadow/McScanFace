<?php

namespace App\Http\Controllers;

use Auth;
use App\Server;
use Carbon\Carbon;
use App\Http\Requests\StoreServerRequest;
use Illuminate\Http\Request;
use App\Repositories\ServerRepositoryInterface;
use PHPUnit\Framework\Constraint\IsEmpty;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use phpseclib\Crypt\RSA;

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(StoreServerRequest $request)
    {
        //
        // Generate SSH Key for the server
        //
        $server_uuid = Uuid::uuid4();
        $rsa = new RSA();
        $rsa->setPublicKeyFormat(RSA::PUBLIC_FORMAT_OPENSSH);
        $rsa->setPrivateKeyFormat(RSA::PRIVATE_FORMAT_OPENSSH);
        //$rsa->comment = $request->name . '-' . $server_uuid;
        $rsa->comment = Carbon::now()->timestamp . '-' . $server_uuid;
        $result = $rsa->createKey(4096);


        $server_create = $this->servers->create([
            'uuid'        => $server_uuid,
            'ip'          => $request->ip,
            'port'        => $request->port,
            'private_key' => $result['privatekey'],
            'public_key'  => $result['publickey'],
            'user'        => $request->user,
            'name'        => $request->name,
            'user_id'     => Auth::user()->id,
        ]);

        if($server_create) {
            $request->session()->flash('server_success', 'Added server <b>' . $request->name . '</b> successfully.');
        }
        else{
            $request->session()->flash('server_error', 'Something went wrong while adding: <b>' . $request->name . '</b>.');
        }

        return redirect()->route('server_overview');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return view('servers.detail', ['server' => $this->servers->find($id)]);

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
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        //
        if($this->servers->delete($request->id))
        {
            $request->session()->flash('server_success', 'Deleted server <b>' . $request->name . '</b> successfully.');
        }
        else
        {
            $request->session()->flash('server_error', 'Something went wrong while deleting: <b>' . $request->name . '</b>.');
        }
        return redirect()->route('server_overview');
    }
}
