@extends('layouts.master3')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Scan') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('post_create_scan') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Scan Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="output_format" class="col-md-4 col-form-label text-md-right">{{ __('Output Format') }}</label>

                                <div class="col-md-6">
                                    <input id="output_format" type="text" class="form-control @error('output_format') is-invalid @enderror" name="output_format" value="{{ old('output_format') }}" required autocomplete="output_format" autofocus>

                                    @error('output_format')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="port" class="col-md-4 col-form-label text-md-right">{{ __('Ports') }}</label>

                                <div class="col-md-6">
                                    <input id="ports" type="text" class="form-control @error('ports') is-invalid @enderror" name="ports" value="{{ old('ports') }}" autocomplete="ports" autofocus>

                                    @error('ports')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="port" class="col-md-4 col-form-label text-md-right">{{ __('Top ports') }}</label>

                                <div class="col-md-6">
                                    <input id="top_ports" type="text" class="form-control @error('top_ports') is-invalid @enderror" name="top_ports" value="{{ old('top_ports') }}" autocomplete="top_ports" autofocus>

                                    @error('top_ports')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="port" class="col-md-4 col-form-label text-md-right">{{ __('Rate') }}</label>

                                <div class="col-md-6">
                                    <input id="rate" type="text" class="form-control @error('rate') is-invalid @enderror" name="rate" value="{{ old('rate') }}" required autocomplete="rate" autofocus>

                                    @error('rate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="port" class="col-md-4 col-form-label text-md-right">{{ __('IP Ranges') }}</label>

                                <div class="col-md-6">
                                    <textarea id="ip_ranges" type="text" class="form-control @error('ip_ranges') is-invalid @enderror" name="ip_ranges" value="{{ old('ip_ranges') }}" required autocomplete="ip_ranges" autofocus></textarea>

                                    @error('ip_ranges')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="banners" class="col-md-4 col-form-label text-md-right">{{ __('Banners') }}</label>

                                <div class="col-md-6">
                                    <input id="banners" type="checkbox" class="form-control @error('banners') is-invalid @enderror" name="banners" value="{{ old('banners') }}" autocomplete="banners" autofocus>

                                    @error('banners')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!--
                            <div class="form-group row">
                                <label for="passkey" class="col-md-4 col-form-label text-md-right">{{ __('Password/User Key') }}</label>

                                <div class="col-md-6">
                                    <input id="passkery" type="text" class="form-control @error('passkey') is-invalid @enderror" name="passkey" value="{{ old('passkey') }}" required autocomplete="passkey" autofocus>

                                    @error('passkey')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            -->

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add Scan') }}
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
