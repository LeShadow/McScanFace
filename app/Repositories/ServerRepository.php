<?php


namespace App\Repositories;

use App\Server;

class ServerRepository implements UserRepositoryInterface
{
    protected $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function find($id)
    {
        return Server::find($id);
    }

    public function all()
    {

    }

    public function delete($id)
    {

    }

    public function update($id, array $data)
    {

    }

    public function create(array $data)
    {
        $server = Server::new();
        $server->ip = $data['ip'];
        $server->port = $data['port'];
        $server->user = $data['user'];
        $server->passkey = $data['passkey'];
        $server->name = $data['name'];

        return $server->save();
    }
}
