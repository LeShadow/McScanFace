@extends('layouts.master3')

@section('content')
<div class="card my-5 shadow-sm">
    <div class="card-header">
        Form
    </div>
    <div class="card-body">
        <h5 class="card-title px-3">Login</h5>
        <p class="card-text">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group row px-3">
                <label for="exampleInputEmail1" class="col-sm-4">Email address</label>
                <input type="email" class="form-control col-sm-8 @error('email') is-invalid @enderror" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="form-group px-3 row">
                <label for="exampleInputPassword1" class="col-sm-4">Password</label>
                <input type="password" class="form-control col-sm-8 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
            </div>
            <div class="form-group px-3 row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </div>

        </form>
        </p>
    </div>
</div>
@endsection
