@extends('layouts.app')
@section('content')
    <div class="container jumbotron">
        <div class="row">
            <div class="col-12">
                <p class="display-4">Edição de Usuários</p>
            </div>
        </div>
        <form action="/users/{{$user->id}}" method="post" class="row" id='frm_users'>
            @csrf
            {{method_field('PUT')}}
            <div class="form-group col-12 col-md-6">
                <label for="name">Nome</label>
                <input type="text" class="form-control" id='name' required name='name' value='{{$user->name}}'>
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id='email' required name='email' value='{{$user->email}}'>
            </div>
            @if(!$user->link->isEmpty())
                <div class='col-md-4 col-12 mt-4'>
                    <p class="h4">Selecione ao lado os links aos quais o usuário poderá ter acesso</p>
                </div>
                <div class='col-2 mt-4 '>
                    <span  class="">
                        <p class="h5"><strong>Permissões</strong></p>
                        @foreach($links as $link)
                            @if($user->link->contains($link->id))
                                <div class="form-check">
                                    <input class="form-check-input" checked onclick="handleClick(this);" type="checkbox" name="{{$link->descricao}}" value="{{$link->id}}" id="ck_{{$link->id}}">
                                    <input type='hidden' name='permissao[]' id='input-hidden' value="{{$link->id}}">
                                    <label class="form-check-label" for="ck_{{$link->id}}">
                                        {{$link->descricao}}
                                    </label>
                                 </div>
                            @else
                                <div class="form-check">
                                    <input class="form-check-input" onclick="handleClick(this);" type="checkbox" name="{{$link->descricao}}" value="{{$link->id}}" id="ck_{{$link->id}}">
                                    <label class="form-check-label" for="ck_{{$link->id}}">
                                    {{$link->descricao}}
                                    </label>
                                </div>
                            @endif
                        @endforeach
                    </span>
                </div>
                <div class=" col-12 col-md-3 " id='boxes'>
                    <p class='h4'>Novas Permissões</p>
                </div> 
            @else
                <div class='col-12 col-md-4 mt-4'>
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
                <div class=" col-12 col-md-3" id='boxes'>
                    <p class='h4'>Novas Permissões</p>
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
                    <button type='submit' class='btn btn-success'>Atualizar</button>
                    <a href='{{route("users")}}' class='btn btn-primary'>Usuários</a>
                </div>
            </form>
        </div>
    </div>
@endsection
<script>

        function marcarDesmarcar(){
                $(".marcar").each(
                    function() {
                        
                        if ($(this).prop("checked")) {
                            $(this).prop("checked", false);
                            handleClick(this);
                        } else {
                            $(this).prop("checked", true);
                            handleClick(this);
                        }
                    }
                );
        }

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
      
</script>