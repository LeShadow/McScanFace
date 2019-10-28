@extends('layouts.master3')

@section('content')
                <div class="card my-3">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                            <div class="alert alert-success" role="alert">
                                Welcome {{ $user->name }}
                            </div>
                    </div>
                </div>
@endsection
