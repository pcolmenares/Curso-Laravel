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
        $user=User::find($id);
       //dd($user);
        return view('users.detail',[
            'user'=> $user,
        ]);
    }
    public function create()
    {
        return view('users.create');
    }

}
