@extends('layouts.master3')

@section('content')
    <div class="my-5">
        @if(Session::has('server_success'))
            <p class="alert alert-success">{!! Session::get('server_success') !!}</p>
        @endif
        @if(Session::has('server_error'))
            <p class="alert alert-danger">{!! Session::get('server_error') !!}</p>
        @endif
    <div class="card shadow-sm">
        <div class="card-header">
            Server Dashboard
            <a href="{{ route('get_create_server') }}" role="button" class="btn btn-primary btn-sm float-right">Add Server</a>
        </div>
        <div class="card-body">
            <h5 class="card-title px-3">Servers</h5>

            <p class="card-text">
            <div class="table-responsive">
<table class="table table-hover table-striped">
    <thead>
    <tr>
        <th scope="col">Name</th>
        <th scope="col">IP</th>
        <th scope="col">Port</th>
        <th scope="col">User</th>
        <th scope="col" class="text-center">Status</th>
        <th scope="col" class="text-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    @if(count($servers)>0)
        @foreach($servers as $server)
    <tr class='clickable-row' data-href='{{asset('/servers/' . $server->id)}}'>
        <td>{{ $server->name }}</td>
        <td>{{ $server->ip }}</td>
        <td>{{ $server->port }}</td>
        <td>{{ $server->user }}</td>
        <td class="text-center">
            @if($server->status == 1)
                <span class="badge badge-danger">Offline</span>
            @else
                <span class="badge badge-success">Online</span>
            @endif
        </td>
        <td><div class="btn-group btn-group-sm float-right" role="group" aria-label="Server Actions">
                <a href="{{ route('get_edit_server', ['id'=>$server->id]) }}" role="button" class="btn btn-primary btn-sm">Edit Server</a>
                <a href="{{ route('delete_server') }}" role="button" class="btn btn-danger btn-sm">Delete Server</a>
            </div>
        </td>
    </tr>
    @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center">
                Empty server list
            </td>
        </tr>
    @endif
    </tbody>
</table>
            </div>
            </p>
        </div>
    </div>

    </div>
@endsection
