<?php


namespace App\Repositories;

use App\Server;
use Auth;
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
        //return Server::where($condition[0], $condition[1], $condition[2])->where('user_id', '=', Auth::user()->id)->get();
        if(count($condition) == count($condition, 1))
        {
            $query_condition = [$condition];
        }
        else
        {
            $query_condition = $condition;
        }
        return Server::where($query_condition)->get();
    }

    public function all()
    {

    }

    public function delete($id)
    {
        $server = Server::find($id);
        return $server->delete();
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
        foreach($data as $key => $value) {
            $server->$key = $value;
        }
        $server->user_id = Auth::user()->id;
        return $server->save();
    }
}
