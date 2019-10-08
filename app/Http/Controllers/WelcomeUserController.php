<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeUserController extends Controller
{
    public function index ($name,$nickname=null)
    {
        $name=ucfirst($name);
        if (empty($nickname))
        {

            return "Bienvenido {$name}";
        }
        else
        {
            $nickname=ucfirst($nickname);
            return "Bienvenido {$name}, Tu apodo es {$nickname}";
        }
    }
}
