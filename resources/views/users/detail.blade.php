@extends('layouts.master3')

@section('content')
                <div class="card my-3">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                            <div class="alert alert-success" role="alert">
                                Welcome {{ $user->name }}
                            </div>
                        <div class="row">
                        <div class="p-3 mb-2 bg-primary text-white">.bg-primary</div>
                        <div class="p-3 mb-2 bg-info text-white">.bg-primary</div>
                        </div>
                    </div>
                </div>
@endsection
