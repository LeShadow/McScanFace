@extends('layouts.master3')

@section('content')
    <div class="card my-5 shadow-sm">
        <div class="card-header">
            Server Dashboard
            <a href="{{ route('get_create_server') }}" role="button" class="btn btn-primary btn-sm float-right">Add Server</a>
        </div>
        <div class="card-body">
            <h5 class="card-title px-3">Servers</h5>

            <p class="card-text">
<table class="table">
    <thead>
    <tr>
        <th scope="col">Name</th>
        <th scope="col">IP</th>
        <th scope="col">Port</th>
        <th scope="col">User</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    @if(count($servers)>0)
        @foreach($servers as $server)
    <tr>
        <td>{{ $server->name }}</td>
        <td>{{ $server->ip }}</td>
        <td>{{ $server->port }}</td>
        <td>{{ $server->user }}</td>
        <td><div class="btn-group btn-group-sm" role="group" aria-label="Server Actions">
                <a href="{{ route('get_edit_server', ['id'=>$server->id]) }}" role="button" class="btn btn-primary btn-sm float-right">Edit Server</a>
                <a href="{{ route('delete_server') }}" role="button" class="btn btn-danger btn-sm float-right">Delete Server</a>
            </div>
        </td>
    </tr>
    @endforeach
    @else
        <tr>
            <td colspan="4" class="text-center">
                Empty server list
            </td>
        </tr>
    @endif
    </tbody>
</table>
            </p>
        </div>
    </div>
@endsection
