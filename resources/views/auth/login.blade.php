@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
    <img src="{{asset('imgs\logo.png')}}" alt="" class="img-fluid">
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
           
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="input-group mb-3 col-6 offset-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">@</span>
                                </div>
                                <input type="email" id='email' class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="email@abv.com.br" aria-label="email" aria-describedby="basic-addon1" autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="input-group mb-3 col-6 offset-3">
                                <div class="input-group-prepend prependpass">
                                    <span class="input-group-text passinput" id="basic-addon2">
                                        <span class="spanprepend">
                                            *
                                        </span>    
                                    </span>
                                </div>
                                <input type="password" id='password' class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"  placeholder="******" aria-label="senha" aria-describedby="basic-addon2">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

        

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Login') }}
                                </button>   
                            </div>
                        </div>
                    </form>
                
        </div>
    </div>
</div>
@endsection
