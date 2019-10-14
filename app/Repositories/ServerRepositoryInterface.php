<?php


namespace App\Repositories;


interface ServerRepositoryInterface
{
    public function find($id);
    public function all();
    public function delete($id);
    public function update($id, array $data);
    public function create(array $data);

}
