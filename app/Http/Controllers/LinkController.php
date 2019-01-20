<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\link;



class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        if($user->reset == "sim"){
            return view('redefinir');
        }
        if($user->perfil == "usuário"){
            $links = Link::join("permissoes", 'links.id', '=', 'permissoes.link_id')
                ->where([['permissoes.user_id', '=', $user->id]])->paginate(8);       
            return view('links', compact('links'), compact('user'));
        }else{
            $links = Link::paginate(8);
            return view('linksAdmin', compact('links'), compact('user'));
        }
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cadastrarLink');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'descricao'=>'required|unique:links'
        ]);
        $link = Link::create($request->all());
        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $link = Link::find($id);
        if(isset($link)){
            return view('editLink', compact('link'));
        }
        return redirect('/home');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'descricao'=>'required|unique:users'
        ]);
        $link = Link::find($id);
        if(isset($link)){
            $link->descricao = $request->input('descricao');
            $link->link = $request->input('link');
            $link->save();
        }
        return redirect('/home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $link = Link::find($id);
        if(isset($link)){
            $link->delete();
            return redirect('/home');
        }
        return redirect('/home');
    }
}
