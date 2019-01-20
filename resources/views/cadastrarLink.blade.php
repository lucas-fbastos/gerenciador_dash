@extends('layouts.app')
@section('content')
    <div class="container jumbotron">
        <div class="row">
            <div class="col-12">
                <p class="display-4">
                    Cadastro de Links
                </p>
                <form action="/save.links" method='POST'>
                @csrf
                    <div class="form-group">
                        <label for="desc">Descrição</label>
                        <input type="text" class="form-control" id='desc' required name='descricao'>
                    </div>
                    <div class="form-group">
                        <label for="link">Link da Planilha</label>
                        <input type="text" class="form-control" id='link' required name='link'>
                    </div>
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div class=" col-12 alert alert-danger" row='alert'>
                                {{$error}}
                            </div>
                        @endforeach
                    @endif
                    <button type='submit' class='btn btn-success'>Cadastrar</button>
                    <a href='{{route("links")}}' class='btn btn-primary'>Meus Links</a>
                </form>
            </div>
        </div>
        
    </div>
@endsection
