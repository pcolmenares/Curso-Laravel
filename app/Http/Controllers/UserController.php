<?php

namespace App\Http\Controllers;

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
        return view('users.new');
    }
    public function store()
    {
        $data=request()->all();

        //dd($data);
        User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password']),
        ]);
        return redirect()->route('users.index');
    }

}
