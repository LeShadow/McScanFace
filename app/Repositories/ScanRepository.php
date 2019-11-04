<?php


namespace App\Repositories;

use App\Scan;
use Auth;
class ScanRepository implements ScanRepositoryInterface
{
    protected $scan;

    public function __construct(Scan $server)
    {
        $this->scan = $server;
    }

    public function find($id)
    {
        return Scan::find($id);
    }

    public function findWhere(array $condition)
    {
        if(count($condition) == count($condition, 1))
        {
            $query_condition = [$condition];
        }
        else
        {
            $query_condition = $condition;
        }
        return Scan::where($query_condition)->get();
    }

    public function all()
    {

    }

    public function delete($id)
    {
        $scan = Scan::find($id);
        return $scan->delete();
    }

    public function update($id, array $data)
    {
        $scan = Scan::find($id);
        foreach($data as $key => $value) {
            $scan->$key = $value;
        }
        return $scan->save();
    }

    public function create(array $data)
    {
        $scan = new Scan();
        foreach($data as $key => $value) {
            $scan->$key = $value;
        }
        $scan->user_id = Auth::user()->id;
        return $scan->save();
    }
}
