@extends('layouts.master3')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Preferences') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('post_edit_prefs') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Elasticsearch Endpoint') }}</label>

                                <div class="col-md-6">
                                    <input id="es_endpoint" type="text" class="form-control @error('es_endpoint') is-invalid @enderror" name="es_endpoint" value="{{ $prefs[0]->es_endpoint }}" required autocomplete="name" autofocus>

                                    @error('es_endpoint')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save preferences') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
