@extends('layouts.app')
@section('content')
    <div class="container jumbotron">
        <div class="row">
                @if($user->perfil == 'admin' || $user->perfil == 'super user')
                    <div class="col-4">
                        <a href="{{route('novoLink')}}" class='btn btn-success btn-block'> + Novo link</a>
                    </div>
                @endif
                @if($links->isEmpty())
                    <div class="col-12">
                        <p class="display-4">
                            Não existem links cadastrados!
                        </p>
                    </div>
                @else
                    <div class="col-8">
                        <p class="display-4">
                            Links Cadastrados
                        </p>
                    </div>
               </div>
               <div class="row">
                @foreach($links as $link)
                    <div class='col-10 offset-1 col-md-3 offset-md-0'>
                        <div class="card text-center mb-4">
                            <div class="card-header">{{$link->descricao }}</div>
                            <div class="card-body">
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#dash{{$link->id}}">
                                Abrir Dashboard
                            </button>
                            </div>
                @if($user->perfil == 'admin' || $user->perfil == 'super user')
                            <div class="card-footer">
                                <a href="/links/{{$link->id}}" class='btn btn-primary'>Editar</a>
                                <a href="#" class='btn btn-danger'  data-toggle="modal" data-target="#deleteModal{{$link->id}}">Apagar</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal fade" id="deleteModal{{$link->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Excluir Links</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">Deseja apagar esse Link?
                                        <p class='text-center'><strong>{{$link->descricao}}</strong></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <form action="/links/{{$link->id}}" method='POST'>
                                            @csrf
                                            {{method_field('DELETE')}}
                                            <button type="submit" class="btn btn-danger">Excluir</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="dash{{$link->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog modal-full" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <iframe class='iframe-full' src="https://{{$link->link}}&output=embed" frameborder="0"></iframe>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                
                            </div>
                            </div>
                        </div>
                    </div>

                @else
                        </div>
                        </div>
                      
                @endif
                @endforeach
                @endif  
                   <div class="col-12"> 
                        {{$links->links()}}
                    </div>
            </div>
    </div>
@endsection
