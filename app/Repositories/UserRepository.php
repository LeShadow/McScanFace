<?php


namespace App\Repositories;

use App\User;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function find($id)
    {
        return User::find($id);
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
}
