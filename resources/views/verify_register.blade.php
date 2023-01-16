@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <div class="form-group row">
                        <label id="title1" for="Field1" class="desc" style="text-align: justify; font-size: 12pt; font-weight: normal; margin: 0px 15px;">

                        Vamos a verificar la información registrada nos comunicaremos muy pronto para darte el acceso al sistema.<br>
                        </label>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-7 offset-md-5" style="padding-left: 0px;">
                            <a href="/" class="btn btn-danger" >Regresar</a>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection