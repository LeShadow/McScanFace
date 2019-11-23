@extends('layouts.master3')

@section('content')
    <div class="row">
    <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card my-5 shadow-sm">
                    <div class="card-header">{{ __('Preferences') }} <a href="{{ route('get_edit_prefs') }}" role="button" class="btn btn-primary btn-sm float-right">Edit Preferences</a></div>

                    <div class="card-body">
                        <div class="row p-1">
                            <div class="border-bottom col-sm-6 text-left mb-3"><p>Elasticsearch Endpoint:</p></div> <div class="border-bottom col-sm-6 text-right mb-3"><p>{{ $prefs[0]->es_endpoint }}</p></div>
                        </div>
                    </div>
                </div>
            </div>
    <div class="col-md-2"></div>
    </div>
@endsection
