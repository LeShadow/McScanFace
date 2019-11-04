@extends('layouts.master3')

@section('content')
    <div class="row">
    <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card my-5 shadow-sm">
                    <div class="card-header">{{ __('Scan Details') }}</div>

                    <div class="card-body">
                        <div class="row p-1">
                            <div class="border-bottom col-sm-6 text-left mb-3"><p>Name:</p></div> <div class="border-bottom col-sm-6 text-right mb-3"><p>{{ $server->name }}</p></div>
                            <div class="border-bottom col-sm-6 text-left mb-3"><p>IP:</p></div> <div class="border-bottom col-sm-6 text-right mb-3"><p>{{ $server->ip }}</p></div>
                            <div class="border-bottom col-sm-6 text-left mb-3"><p>User:</p></div> <div class="border-bottom col-sm-6 text-right mb-3"><p>{{ $server->user }}</p></div>
                            <div class="border-bottom col-sm-6 text-left mb-3"><p>Port:</p></div> <div class="border-bottom col-sm-6 text-right mb-3"><p>{{ $server->port }}</p></div>
                            <div class="col-sm-4 text-left"><p>SSH Key:</p><p><span onclick="copyText('public_key');">copy this</span></p></div> <div class="col-sm-8 text-right text-wrap"><p><textarea id="public_key" class="form-control" style="overflow:auto;" id="exampleFormControlTextarea1" rows="3" readonly>{{ $server->public_key }}</textarea></p></div>
                        </div>
                    </div>
                </div>
            </div>
    <div class="col-md-3"></div>
    </div>
@endsection
