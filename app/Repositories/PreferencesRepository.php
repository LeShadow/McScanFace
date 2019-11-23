<?php


namespace App\Repositories;

use App\Preferences;
class PreferencesRepository implements PreferencesRepositoryInterface
{
    protected $scan_files;

    public function __construct(Preferences $scan_file)
    {
        $this->scan_files = $scan_file;
    }

    public function find($id)
    {
        return Preferences::find($id);
    }

    public function findWhere(array $condition)
    {
        $query_condition = $condition;

        if(count($condition) == count($condition, 1))
        {
            $query_condition = [$condition];
        }

        return Preferences::where($query_condition)->get();
    }

    public function all()
    {

    }

    public function delete($id)
    {
        $scan_file = Preferences::find($id);
        return $scan_file->delete();
    }

    public function update($id, array $data)
    {
        $scan_file = Preferences::find($id);
        foreach($data as $key => $value) {
            $scan_file->$key = $value;
        }
        return $scan_file->save();
    }

    public function create(array $data)
    {
        $scan_file = new Preferences();
        foreach($data as $key => $value) {
            $scan_file->$key = $value;
        }
        return $scan_file->save();
    }
}
