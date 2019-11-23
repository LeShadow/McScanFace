<?php


namespace App\Repositories;


interface PreferencesRepositoryInterface
{
    public function find($id);
    public function all();
    public function delete($id);
    public function update($id, array $data);
    public function create(array $data);
    public function findWhere(array $condition);

}

