<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Auth;
class UserController extends Controller
{
    //
    protected $users;
    public function __construct(UserRepositoryInterface $user)
    {
        $this->users = $user;
    }

    public function show()
    {

        return view('users.detail', [ 'user' => $this->users->find(Auth::user()->id)]);
        //dd($this->users->find(Auth::user()->id));
    }
}
