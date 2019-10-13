<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Profession;
class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //dd($profession);
        // varias formas de insertar datos para evitar inyeccion SQL
        //DB::insert('INSERT INTO USERS (title) VALUES(?)',["Programador Web"]);
       // DB::insert('INSERT INTO USERS (title) VALUES(:title)',['title'=>'Programador Web']);
//        DB::table('professions')->insert([
//            'title'=>'Programador Web',
//        ]);

                Profession::create([
            'title'=>'Programador Web',
        ]);
        Profession::create([
            'title'=>'Diseñador Web',
        ]);
        Profession::create([
            'title'=>'Desarrollador Back-End',
        ]);
        Profession::create([
            'title'=>'Ingeniero de Sistemas',
        ]);

        factory(Profession::class)->times(6)->create([

        ]);



       // DB::table('professions')->where('title','=','Desarrollador Back-End')->delete();

    }
}
