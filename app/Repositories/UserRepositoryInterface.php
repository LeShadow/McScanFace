<?php


namespace App\Repositories;


interface UserRepositoryInterface
{
    public function find($id);
    public function all();
    public function delete($id);
    public function update($id, array $data);

}
