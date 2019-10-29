<?php


namespace App\Repositories;

use App\Server;

class ServerRepository implements ServerRepositoryInterface
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

    public function findWhere(array $condition)
    {
        return Server::where($condition[0], $condition[1], $condition[2])->get();
    }

    public function all()
    {

    }

    public function delete($id)
    {

    }

    public function update($id, array $data)
    {
        $server = Server::find($id);
        foreach($data as $key => $value) {
            $server->$key = $value;
        }
        return $server->save();
    }

    public function create(array $data)
    {
        $server = new Server();
        $server->uuid = $data['uuid'];
        $server->ip = $data['ip'];
        $server->port = $data['port'];
        $server->user = $data['user'];
        $server->private_key = $data['private_key'];
        $server->public_key = $data['public_key'];
        $server->name = $data['name'];
        $server->user_id = $data['user_id'];
        return $server->save();
    }
}
