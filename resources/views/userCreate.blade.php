@extends('layouts.app')
@section('content')
    <div class="container jumbotron">
        <div class="row">
            <div class="col-12">
                <p class="display-4">Cadastro de Usuários</p>
            </div>
        </div>
            <form action="/users/cadastro" class="row" method="post" id='frm_users'>
                @csrf
                <div class="form-group col-12 col-md-4">
                    <label for="ip_nome">Nome</label>
                    <input name="nome" id='ip_nome' type="text" required class="form-control" placeholder='Digite o nome aqui'>
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="ip_email">E-mail</label>
                    <input name="email" id='ip_email' type="email" required class="form-control" placeholder='email@abv.com'>
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="sl_perfil">Perfil</label>
                    <select name="perfil" id="sl_perfil" class="form-control" required>
                        <option value="">Selecione</option>
                        <option value="usuário">Usuário</option>
                        <option value="admin">Admin</option>
                        <option value="super user">Super User</option>
                    </select>
                </div>
                
        @if(!$links->isEmpty())
        <div class='col-4 mt-4'>
            <p class="h4">Selecione ao lado os links aos quais o usuário poderá ter acesso</p>
        </div>
            <div class='col-2  mt-4'>
                <span  class="">
                    <p class="h5"><strong>Permissões</strong></p>
                    <button class="btn btn-primary btn-sm" type="button" onclick="marcarDesmarcar();">Marcar todos</button>
            @foreach($links as $link)
                        <div class="form-check">
                           
                            <input class="form-check-input marcar" onclick="handleClick(this);" type="checkbox" name="{{$link->descricao}}" value="{{$link->id}}" id="ck_{{$link->id}}">
                            <label class="form-check-label" for="ck_{{$link->id}}">
                                {{$link->descricao}}
                            </label>
                        </div>
            @endforeach
                </span>
            </div>
            <div class="col-12 col-md-3" id='boxes'>
                
            </div>
        @endif
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class=" col-12 alert alert-danger" row='alert'>
                    {{$error}}
                </div>
            @endforeach
        @endif
            <div class="col-12 col-md-3 mt-5">
                <button class="btn btn-success btn-block" type='submit'>Cadastrar</button>
                <button class="btn btn-secondary btn-block" type='reset' onclick='apagarTodos();'>Limpar</button>
            </div>
            </form> 
    </div>
@endsection
<script>
        function handleClick(cb) {
            if(cb.checked){
                $('#frm_users').append("<input type='hidden' name='permissao[]' id='input-hidden' value='"+cb.value+"'>");
                $('#boxes').append('<div id="box-item" class="border border-primary bg-light m-4 rounded-right text-center">'+cb.name +'</div>');
            }else{
                $('input[id=input-hidden]').each(function() {
                    if ($(this).val() == cb.value) {
                        $(this).remove();
                    }
                });
                $('div[id=box-item]').each(function() {
                    if ($(this).text() == cb.name) {
                        $(this).remove();
                    }
                });
            }
        }

        function marcarDesmarcar(){
            $(".marcar").each(
                function() {
                    if ($(this).prop("checked")) {
                        $(this).prop("checked", false);
                    } else {
                           $(this).prop("checked", true);
                    }
                }
            );
        }

        function apagarTodos() {
            $('div[id=box-item]').each(function() {
                    $(this).remove();
            });
            $('input[id=input-hidden]').each(function() {
                     $(this).remove();
            });
        }

</script>