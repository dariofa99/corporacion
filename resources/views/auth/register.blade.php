@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                      {{--   <div class="form-group row">
                            <label for="inputName" class="col-md-4 col-form-label text-md-right">Tipo identificación</label>
     
                            <div class="col-sm-6">
                             @foreach ($types_identification as $key => $tipo_doc )
                                <div class="form-check form-check-inline">
                                  <input  class="form-check-input" checked type="radio" name="type_identification_id" id="type_identification-{{$key}}" value="{{$key}}">
                                  <label class="form-check-label" for="inlineRadio1">{{$tipo_doc}}</label>
                                </div>
                            @endforeach
                            </div>
     
                          </div> --}}
                          <input id="type_identification_id" type="hidden" value="6"  name="type_identification_id" value="{{ old('type_identification_id') }}" required autocomplete="type_identification_id" autofocus>

                              
                          <div class="form-group row">
                            <label for="identification_number" class="col-md-4 col-form-label text-md-right">
                                No. Identificación</label>

                            <div class="col-md-6">
                                <input id="identification_number" type="text" class="form-control @error('identification_number') is-invalid @enderror" name="identification_number" value="{{ old('identification_number') }}" required autocomplete="identification_number" autofocus>

                                @error('identification_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

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
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Número de celular</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="email">

                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        
                        <div class="form-group row"><div class="col-md-12"><div class="form-check" style="text-align: justify;background-color: #ffffff;border-radius: .35rem; font-size: 16px;"><input type="checkbox" name="remember" id="remember" class="form-check-input" style="margin-top: 14px;  margin-right: 0px; margin-bottom: 0px;  margin-left: 0px;" required> <label for="remember" class="form-check-label" style=" padding-top: 10px; padding-right: 15px; padding-bottom: 10px;  padding-left: 15px;">
                                        He le&iacute;do y entiendo que en estos T&eacute;rminos y Condiciones se encuentra el tratamiento de datos, usos, condiciones y restricciones de esta plataforma web. Por ende manifiesto que doy mi consentimiento y acepto lo que en ellos se regula. <br>
                                        <a href="/terminosycondiciones" target="_blank">Click aqu&iacute; para revisar los t&eacute;rminos y condiciones completos.</a>
                            </label></div></div></div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-5">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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
