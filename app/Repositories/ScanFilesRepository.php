<?php


namespace App\Repositories;

use App\ScanFiles;
use Auth;
class ScanFilesRepository implements ScanFilesRepositoryInterface
{
    protected $scan_files;

    public function __construct(ScanFiles $scan_file)
    {
        $this->scan_files = $scan_file;
    }

    public function find($id)
    {
        return ScanFiles::find($id);
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
        return ScanFiles::where($query_condition)->get();
    }

    public function all()
    {

    }

    public function delete($id)
    {
        $scan_file = ScanFiles::find($id);
        return $scan_file->delete();
    }

    public function update($id, array $data)
    {
        $scan_file = ScanFiles::find($id);
        foreach($data as $key => $value) {
            $scan_file->$key = $value;
        }
        return $scan_file->save();
    }

    public function create(array $data)
    {
        $scan_file = new ScanFiles();
        foreach($data as $key => $value) {
            $scan_file->$key = $value;
        }
        return $scan_file->save();
    }
}
