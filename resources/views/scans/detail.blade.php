@extends('layouts.master4')

@section('content')
    <div class="row">
            <div class="col-md-6">
                <div class="card my-5 shadow-sm">
                    <div class="card-header">{{ __('Scan Details') }}</div>

                    <div class="card-body">
                        <div class="row p-1">
                            <div class="border-bottom col-sm-6 text-left mb-3"><p>Name:</p></div> <div class="border-bottom col-sm-6 text-right mb-3"><p>{{ $scan->name }}</p></div>
                            <div class="border-bottom col-sm-6 text-left mb-3"><p>IP Ranges:</p></div> <div class="border-bottom col-sm-6 text-right mb-3"><p>{{ $scan->ip_ranges }}</p></div>
                            <div class="border-bottom col-sm-6 text-left mb-3"><p>Grab banners?:</p></div> <div class="border-bottom col-sm-6 text-right mb-3"><p>{{ $scan->banners }}</p></div>
                            <div class="border-bottom col-sm-6 text-left mb-3"><p>Status:</p></div> <div class="border-bottom col-sm-6 text-right mb-3"><p>{{ $scan->scan_status }}</p></div>
                            <div class="border-bottom col-sm-6 text-left mb-3"><p>Output format:</p></div> <div class="border-bottom col-sm-6 text-right mb-3"><p>{{ $scan->output_format }}</p></div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-md-6">
            <div class="card my-5 shadow-sm">
                <div class="card-header">{{ __('Scan Results') }}</div>

                <div class="card-body">
                    <div class="row p-1">
                        @if(count($files)>0)
                            @foreach($files as $file)
                        <div class="border-bottom col-sm-6 text-left mb-3"><p>Name:  {{$file->filename}}<br /><sub>Hash: {{$file->hash}}</sub></p></div> <div class="border-bottom col-sm-6 text-right mb-3"><p><a href="{{ asset('storage/results/' . $file->filename) }}" class="btn btn-info btn-sm">Download</a><a href="{{ route('exportToEs', ['id'=>$scan->id]) }}" role="button" class="btn btn-dark btn-sm{{$scan->scan_status < 2 ? " disabled" : ""}}"  onclick="event.preventDefault();document.getElementById('export-results-scan-form-{{$scan->id}}').submit();" {{$scan->scan_status < 2 ? 'aria-disabled="true"' : ''}}>Export Results</a>
                                    <form id="export-results-scan-form-{{$scan->id}}" action="{{ route('exportToEs', ['id'=>$scan->id]) }}" method="POST" style="display: none;">
                                        <input type="hidden" name="id" value="{{ $scan->id }}">
                                        @csrf
                                    </form></p></div>
                            @endforeach
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
