@extends('layouts.master3')

@section('content')
    <div class="my-5">
        @if(Session::has('scan_success'))
            <p class="alert alert-success">{!! Session::get('scan_success') !!}</p>
        @endif
        @if(Session::has('scan_error'))
            <p class="alert alert-danger">{!! Session::get('scan_error') !!}</p>
        @endif
    <div class="card shadow-sm">
        <div class="card-header">
            Server Dashboard
            <a href="{{ route('get_create_scan') }}" role="button" class="btn btn-primary btn-sm float-right">Add Scan</a>
        </div>
        <div class="card-body">
            <h5 class="card-title px-3">Scans</h5>

            <p class="card-text">
            <div class="table-responsive">
<table class="table table-hover table-striped">
    <thead>
    <tr>
        <th scope="col">Name</th>
        <th scope="col">IP Ranges</th>
        <th scope="col">Ports/Top Ports</th>
        <th scope="col">Rate</th>
        <th scope="col" class="text-center">Status</th>
        <th scope="col" class="text-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    @if(count($scans)>0)
        @foreach($scans as $scan)
    <!--<tr class='clickable-row' data-href='{{asset('/scans/' . $scan->id)}}'>-->
    <tr>
        <td>{{ $scan->name }}</td>
        <td>{{ $scan->ip_ranges }}</td>
        @if($scan->top_ports > 0)
            <td>{{ $scan->top_ports }}</td>
        @else
            <td>{{ $scan->ports }}</td>
        @endif
        <td>{{ $scan->rate }}</td>
        <td class="text-center">
            @if($scan->scan_status == 0)
                <span class="badge badge-danger">Not Started</span>
            @else
                @if($scan->scan_status == 1)
                    <span class="badge badge-warning">Busy</span>
                @else
                    <span class="badge badge-success">Finished</span>
                @endif
            @endif
        </td>
        <td><div class="btn-group btn-group-sm float-right" role="group" aria-label="Scan Actions">
                <a href="{{ route('post_start_scan', ['id'=>$scan->id]) }}" role="button" class="btn btn-info btn-sm"  onclick="event.preventDefault();document.getElementById('start-scan-form-{{$scan->id}}').submit();" {{$scan->scan_status > 0 ? "disabled" : ""}}>Start Scan</a>
                <form id="start-scan-form-{{$scan->id}}" action="{{ route('post_start_scan', ['id'=>$scan->id]) }}" method="POST" style="display: none;">
                    <input type="hidden" name="id" value="{{ $scan->id }}">
                    @csrf
                </form>
                <a href="{{ route('get_edit_scan', ['id'=>$scan->id]) }}" role="button" class="btn btn-primary btn-sm" {{$scan->scan_status > 0 ? "disabled" : ""}}>Edit Scan</a>
                <!--<a href="{{ route('delete_scan') }}" role="button" class="btn btn-danger btn-sm">Delete Server</a>-->
                <a class="btn btn-danger btn-sm" href="{{ route('delete_scan') }}" onclick="event.preventDefault();document.getElementById('delete-scan-form').submit();" {{$scan->scan_status ===1 ? "disabled" : ""}}>{{ __('Delete Scan') }}</a>

                <form id="delete-server-form" action="{{ route('delete_scan') }}" method="POST" style="display: none;">
                    <input type="hidden" name="id" value="{{ $scan->id }}">
                    @csrf
                </form>
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
