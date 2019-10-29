@extends('layouts.master3')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Server') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('post_create_server') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Server Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('namne') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ip" class="col-md-4 col-form-label text-md-right">{{ __('IP Address') }}</label>

                                <div class="col-md-6">
                                    <input id="ip" type="text" class="form-control @error('ip') is-invalid @enderror" name="ip" value="{{ old('ip') }}" required autocomplete="ip" autofocus>

                                    @error('ip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="port" class="col-md-4 col-form-label text-md-right">{{ __('Port') }}</label>

                                <div class="col-md-6">
                                    <input id="port" type="text" class="form-control @error('port') is-invalid @enderror" name="port" value="{{ old('port') }}" required autocomplete="port" autofocus>

                                    @error('port')
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
                            <div class="form-group row">
                                <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('user') }}</label>

                                <div class="col-md-6">
                                    <input id="user" type="text" class="form-control @error('user') is-invalid @enderror" name="user" value="{{ old('user') }}" required autocomplete="user" autofocus>

                                    @error('user')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add Server') }}
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
