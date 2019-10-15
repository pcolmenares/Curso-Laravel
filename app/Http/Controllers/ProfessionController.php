<?php

namespace App\Http\Controllers;

use App\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProfessionController extends Controller
{
    public function show(){
        $professions=Profession::all();
        //dd($professions);
        return view('users.create')
            ->with('professions',$professions);
    }
}
