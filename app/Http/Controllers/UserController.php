<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Link;
use App\User;
use App\Permissao;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;




class UserController extends Controller
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
        $users = User::paginate(6);
        return view('users', compact('users'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $links = Link::all();
        return view('userCreate', compact('links'));
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
            'email'=>'required|unique:users'
        ]);
        $user = new User();
        $user->name = request()->input('nome');
        $user->email = request()->input('email');
        $user->reset = 'sim';
        $user->perfil = request()->input('perfil');
        //gerar senha temporaria
        $token = md5(uniqid(""));
        $senha = substr($token, 0, 6);
        $user->password = Hash::make($senha);
        $user->save();
        //user criado, agora basta salvar as permissões 
        // recuperar os inputs dinamicos do form
        $report = Input::get('permissao');
        if ($report) {
            for($i=0; $i<count($report);$i++)
            {
                $permissao = new Permissao();
                $permissao->user_id = $user->id;
                $permissao->link_id = intval($report[$i]);
                $permissao->save();
            }
        }
        $request->session()->flash('senha', $senha);

        return redirect('/users');

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
        $user = User::with('link')->where('id', '=',$id)->get();
        $user = $user->first();
        $links = Link::all(); 
        
        if(isset($user)){
            return view('editUser', compact('user', 'links'));
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
        $user =  User::find($id);
        if($user->email != $request->input('email')){

            $request->validate([
                'email'=>'required|unique:users'
                ]);
        }

        if(isset($user)){
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();

            $getPermissaoIds = Permissao::where('user_id', '=',$id)->pluck('link_id')->toArray();
            $report = Input::get('permissao');
            
            if (!$report) {
                $report = [];
            }
                //pega o que tem na request e não tem no banco
                $diffR = array_diff($report, $getPermissaoIds);
                $reindexed_diffR = array_values($diffR);
                //var_dump($reindexed_diffR);die();
                //pega o que tem no banco e não tem na request  
                $diffB = array_diff($getPermissaoIds, $report);
                $reindexed_diffB = array_values($diffB);
           
        
                //insere o que tem na request
                if(count($reindexed_diffR)>0){
                    for($i=0; $i<count($reindexed_diffR);$i++)
                {
                    $permissao = new Permissao();
                    $permissao->user_id = $id;
                    $permissao->link_id = intval($reindexed_diffR[$i]);
                    $permissao->save();
                }
                }

                //apaga o que não tem no banco
                if(count($reindexed_diffB)>0){
                    for($i=0; $i<count($reindexed_diffB);$i++)
                {
                    $permissao = Permissao::where([
                        ['link_id', '=', $reindexed_diffB[$i]],
                        ['user_id', '=', $id]])->delete();
                        
                    //$permissao->delete();
                }
                }
               return redirect("/users/$id");
            }
        
        return redirect('/users');
    }

    public function redefinir(Request $request){
        $user = Auth::user();
        $id = $user->id;
        $senha = $request->input('atual');
       

        $user = User::find($id);
        if (!Hash::check($senha, $user->password)) {
            return view('redefinir');
        }
       if ($request->input('senha') != $request->input('confirmaSenha')) {
            return view('redefinir');
        }
        $senha = $request->input('senha');
        $senhaNova = Hash::make($senha);
        $user->password = $senhaNova;
        $user->reset = "não";
        $user->save();

        return redirect('/');
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(!isset($user)){
            return redirect('/users');
        }
        $user->delete();
        return redirect('/users');
    }

    public function resetar( Request $request, $id){
        $user = User::find($id);
        if(!isset($user)){
            return redirect('/users');
        }
        $user->reset = 'sim';
        $token = md5(uniqid(""));
        $senha = substr($token, 0, 6);
        $user->password = Hash::make($senha);
        $user->save();
        $request->session()->flash('senha', $senha);
        return redirect('/users');

    }
}
