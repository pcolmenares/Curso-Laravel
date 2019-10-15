<?php

namespace App\Http\Controllers;

use App\Profession;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        if(\request()->has('empty'))
        {
            $users=[];
        }
        else
        {
            /*$users=[
                'Pedro',
                'Jessica',
                'Jesus',
                'Jose',
                'Maria',
            ];*/

            //$users=DB::table('users')->get();

            $users=User::all();

           // dd($users);
        }

        $title='Listado de Usuarios';
        //dd(compact(users,title));

        return view('users.index')
            ->with('title',$title)
            ->with('users',$users);

//        return view('users.index',[
//            'users'=> $users,
//            'title'=> $title,
//        ]);
    }
    public function show($id)
    {

//        $user=User::find($id);
       //dd($user);
//        if($user==null){
//            return response()->view('errors.404', [], 404);
//
//        }
        $user=User::findOrFail($id);

        return view('users.detail',[
            'user'=> $user,
        ]);
    }
//La funcion anterior se puede simplificar de la siguiente forma:
//    public function show(User $user){
//        //dd($user);
//        return view('users.detail',compact('user'));
//    }


    public function create()
    {
        $professions=Profession::all();
        return view('users.create')
            ->with('professions',$professions);
    }
    public function store()
    {
        //$data=request()->all();
        //validando datos con laravel
        $data = request()->validate([
            'name' => 'required',
            'email' => 'unique:users,email|required|email',
            'password' => 'between:6,12|required',
            'profession' => ''
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo correo es obligatorio.',
            'email.unique' => 'El correo ya se encuentra registrado.',
            'email.email' => 'El email no es valido.',
            'password.between' => 'El password debe estar entre 6 y 12 caracteres.',
            'password.required' => 'El campo password es obligatorio.',

        ]);


       //dd($data);
        User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password']),
            'profession_id'=>$data['profession'],
        ]);
        return redirect()->route('users.index');
    }
    public function edit(User $user)
    {
        $professions=Profession::all();
        return view('users.edit', ['user' => $user])
            ->with('professions',$professions);
    }

    public function update(User $user){
        $data=request()->validate([
            'name' => 'required',
            //'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)]
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|between:6,12',
            'profession' => ''
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo correo es obligatorio.',
            'email.unique' => 'El correo ya se encuentra registrado.',
            'email.email' => 'El email no es valido.',
            'password.between' => 'El password debe estar entre 6 y 12 caracteres.',

        ]);
        if($data['password']==null){
            unset($data['password']);
        }
        else{
            $data['password']=bcrypt($data['password']);
        }
        //dd($data);
        $user->update($data);


        return redirect()->route('users.detail',['user'=>$user]);
    }

    public function destroy(User $user){
        $user->delete();
        return redirect()->route('users.index');
    }
}
