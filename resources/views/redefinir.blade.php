@extends('layouts.app')
@section('content')
    <div class="container">
        <form action="/redefinir" method='POST'>
        @csrf
        <div class="row">
            <div class="form-group col-6 offset-3">
                <label for="atual">Senha atual</label>
                <input type="password" required class="form-control" id='atual' name='atual'>
            </div>
            <div class="form-group col-6 offset-3">
                <label for="nova">Nova Senha</label>
                <input type="password" required class="form-control" id="nova" name='senha'>
            </div>
            <div class="form-group col-6 offset-3">
                <label for="confirma">Confirmar Nova Senha</label>
                <input type="password" required class="form-control" id="confirma" name='confirmaSenha'>
            </div>
        </div>
        <div class="row">
            <button class="btn btn-primary col-4 offset-4" type='submit'>Salvar</button>
        </div>
        </form>
    </div>

@endsection