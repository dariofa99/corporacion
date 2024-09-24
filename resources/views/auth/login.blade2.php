@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if (session('status'))
            {{-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('status') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> --}}
                <div class="card">
                    <div class="card-header">
                        <h3>Atención!</h3>
                    </div>
                    <div class="card-body">
                        <h1>
                            {{ session('status') }} 
                        </h1>
                    </div>
                    <div class="card-footer">
                        <a href="/login" class="btn btn-primary btn-sm">Regresar</a>
                    </div>
                </div>

              @else
              
              <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="myLoginForm">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('Correo') }}</label>

                            <div class="col-md-7">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-md-7">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-7 offset-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Recordar mi cuenta') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-7 offset-md-3">
                                <button type="submit" class="btn btn-danger">
                                    {{ __('Ingresar') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Olvidaste tu contraseña?') }}
                                    </a>
                                @endif

                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-1 offset-md-5">
                             

                                <a class="btn btn-link" href="{{ route('register') }}">
                                    {{ __('Registrarse?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif
         
        </div>
    </div>
</div>
@endsection
