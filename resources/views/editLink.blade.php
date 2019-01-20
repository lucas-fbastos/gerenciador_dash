@extends('layouts.app')
@section('content')
    <div class="container jumbotron">
        <div class="row">
            <div class="col-12">
                <form action="/links/{{$link->id}}" method="post">
                    @csrf
                    {{method_field('PUT')}}
                    <div class="form-group">
                        <label for="desc">Descrição</label>
                        <input type="text" class="form-control" id='desc' required name='descricao' value='{{$link->descricao}}'>
                    </div>
                    <div class="form-group">
                        <label for="link">Link da Planilha</label>
                        <input type="text" class="form-control" id='link' required name='link' value='{{$link->link}}'>
                    </div>
                    <button type='submit' class='btn btn-success'>Atualizar</button>
                    <a href='{{route("links")}}' class='btn btn-primary'>Meus Links</a>
                </form>
                
            </div>
        </div>
    </div>
@endsection