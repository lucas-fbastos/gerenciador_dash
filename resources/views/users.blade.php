@extends('layouts.app')
@section('content')
@if(session('senha'))
<div class="alert alert-success" role="alert">
  Cadastrado com sucesso! Anote a senha temporária:<strong>{{ session('senha') }}</strong>
</div>

@endif
    <main class="container">
        <div class="row jumbotron">
                <div class="col-8">
                    <p class='display-4'>Usuários</p>
                </div>
                <div class="col-4">
                    <a href="/users/cadastro" class="btn btn-success btn-block">+ Novo Usuário</a>
                </div>
                <table class='table table-hover'>
                    <thead>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Perfil</th>
                        <th>Ação</th>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->perfil}}</td>
                            <td>
                                @if((Auth::user()->perfil == 'admin' && $user->perfil !='super user') 
                                || (Auth::user()->perfil == 'super user') )
                                    <a href="/users/{{$user->id}}" class='btn btn-sm btn-primary'>Editar</a>
                                    <form action="/users/{{$user->id}}" method='POST'>
                                        @csrf
                                        {{method_field('patch')}}
                                        <button type="submit" class="btn btn-sm btn-success">Redefinir Senha</button>
                                    </form>
                                    <form action="/users/{{$user->id}}" method='POST'>
                                        @csrf
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-6 offset-3">
                    {{$users->links()}}
                </div>
            </div>
        </div>
    </main>
@endsection
