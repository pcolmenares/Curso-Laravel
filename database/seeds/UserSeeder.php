<?php

use App\Profession;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //varias formas de consultar datos para evitar inyeccion SQL
        //DB::select('SELECT id from professions where title=?',["Programador Web"]);
        //DB::select('SELECT id FROM professions WHERE title=:title',['title'=>"Programador Web"]);
        //$profession = DB::table('professions')->whereTitle('Programador Web')->first(); whereCampo para consultar el campo
        //$professions = DB::table('professions')->select('id')->take(1)->get();

//        $profession=DB::table('professions')
//            ->select('id')
//            ->where('title','=','Ingeniero de Sistemas')
//            ->first();
        $professionId= Profession::where('title','Ingeniero de Sistemas')->value('id');

        //dd($profession);

//        DB::table('users')->insert([
//           'profession_id'=>$profession->id,
//           'name'=>'Pedro Colmenares',
//            'email'=>'9a5e697fed-a05a34@inbox.mailtrap.io',
//            'password'=>bcrypt('colmena3611'),
//
//        ]);

//        User::create([
//            'profession_id'=>$professionId,
//            'name'=>'Pedro Colmenares',
//            'email'=>'9a5e697fed-a05a34@inbox.mailtrap.io',
//            'password'=>bcrypt('colmena3611'),
//            'is_admin' =>true,
//        ]);
//
//        User::create([
//            'profession_id'=>4,
//            'name'=>'Jessica Noria',
//            'email'=>'jessnoria@gmail.com',
//            'password'=>bcrypt('2603'),
//            'is_admin' =>true,
//        ]);
//        User::create([
//            'profession_id'=>2,
//            'name'=>'Jose Lopez',
//            'email'=>'jose.lopez.@gmail.com',
//            'password'=>bcrypt('3611'),
//            'is_admin' =>false,
//        ]);

        factory(User::class)->create([
            'profession_id'=>$professionId,
            'name'=>'Pedro Colmenares',
            'email'=>'9a5e697fed-a05a34@inbox.mailtrap.io',
            'password'=>bcrypt('colmena3611'),
            'is_admin' =>true,
        ]);
        factory(User::class)->create([
            'profession_id'=>$professionId,
            'name'=>'Jessica Noria',
            'email'=>'jessnoria@gmail.com',
            'password'=>bcrypt('2603'),
            'is_admin' =>true,
        ]);

        factory(User::class,40)->create([
        ]);

    }
}
