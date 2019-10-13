<?php

namespace Tests\Feature;
use App\Profession;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class UsersModuleTest extends TestCase
{
    /** @test */

    use RefreshDatabase;

    function it_loads_the_users_list_page()
    {

        factory(User::class)->create([
            'name' => 'Juan Lopez',
            'profession_id'=>null,
        ]);
        factory(User::class)->create([
            'name' => 'Cristobal Gonzalez',
            'profession_id'=>null,
        ]);

        $this->get('/usuarios')
            ->assertStatus(200)
           // ->assertSee('Usuarios')
            ->assertSee('Juan Lopez')
            ->assertSee('Cristobal Gonzalez')
            ->assertSee('Listado de Usuarios');
    }
    /** @test */
    function muestra_mensaje_si_la_lista_esta_vacia()
    {
        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('No hay usuarios registrados');
    }
    /** @test */
    function it_displays_the_user_details()
    {
        factory(Profession::class)->times(1)->create([

        ]);
        $user=factory(User::class)->create([
            'name' => 'Pedro Colmenares',
            'profession_id'=>1,
        ]);

        $this->get('/usuarios/'.$user->id)
            ->assertStatus(200)
            ->assertSee('Pedro Colmenares');
    }
    /** @test */
    function it_displays_404_error_if_user_is_not_found()
    {

        $this->get('/usuarios/9999')
            ->assertStatus(404)
            ->assertSee('Usuario no encontrado');
    }

    /** @test */
    function it_loads_the_new_users_page()
    {
        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee('Crear Usuario');
    }

    /** @test */
    function it_create_a_new_user(){

       // $this->withExceptionHandling();
        $this->post(route('users.store'),[
            'name'=>'Pedro Colmenares',
            'email'=>'9a5e697fed-a05a34@inbox.mailtrap.io',
            'password'=>'colmena3611',
        ])->assertRedirect(route('users.index'));


        $this->assertCredentials([
            'name'=>'Pedro Colmenares',
            'email'=>'9a5e697fed-a05a34@inbox.mailtrap.io',
            'password'=>'colmena3611',
        ]);

        //Para verificar los datos insertados en la base de datos se usa la forma siguiente. El problema sucede cuando se
        // insertan contrasenas con bcrypt que no va a verificar correctamente porque este helper crea contrasenas cada ves que se invoca
//        $this->assertDatabaseHas('users',[
//            'name'=>'Pedro Colmenares',
//            'email'=>'9a5e697fed-a05a34@inbox.mailtrap.io',
//            //'password'=>'colmena3611',
//        ])->assertRedirect(route('users.index'));
    }
}
