<?php

namespace Tests\Feature;
use App\Profession;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class UsersModuleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */


    function it_loads_the_users_list_page()
    {

        factory(User::class)->create([
            'name' => 'Juan Lopez',
            'profession_id' => null,
        ]);
        factory(User::class)->create([
            'name' => 'Cristobal Gonzalez',
            'profession_id' => null,
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
        $user = factory(User::class)->create([
            'name' => 'Pedro Colmenares',
            'profession_id' => 1,
        ]);

        $this->get('/usuarios/' . $user->id)
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
        $this->get('/usuarios/crear')
            ->assertStatus(200)
            ->assertSee('Nuevo Usuario');
    }

    /** @test */
    function it_create_a_new_user()
    {

        $this->withoutExceptionHandling();
        $this->post(route('users.store'), [
            'name' => 'Pedro Colmenares',
            'email' => '9a5e697fed-a05a34@inbox.mailtrap.io',
            'password' => 'colmena3611',
            'profession' => null,
        ])->assertRedirect(route('users.index'));

        $this->assertCredentials([
            'name' => 'Pedro Colmenares',
            'email' => '9a5e697fed-a05a34@inbox.mailtrap.io',
            'password' => 'colmena3611',
            'profession_id' => null,
        ]);

        //Para verificar los datos insertados en la base de datos se usa la forma siguiente. El problema sucede cuando se
        // insertan contrasenas con bcrypt que no va a verificar correctamente porque este helper crea contrasenas cada ves que se invoca
//        $this->assertDatabaseHas('users',[
//            'name'=>'Pedro Colmenares',
//            'email'=>'9a5e697fed-a05a34@inbox.mailtrap.io',
//            //'password'=>'colmena3611',
//        ])->assertRedirect(route('users.index'));
    }

    /** @test */
    function the_name_is_required()
    {
        $this->from(route('users.create'))
            ->post(route('users.store'), [
                'name' => '',
                'email' => 'p3dro.colmenares@gmail.com',
                'password' => '123456',
                'profession' => null
            ])
            ->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio.']);
        $this->assertEquals(0, User::count());
//        $this->assertDatabaseMissing('users', [
//            'email' => 'duilio@styde.net',
//        ]);
    }

    /** @test */
    function the_email_is_required()
    {
        $this->from(route('users.create'))
            ->post(route('users.store'), [
                'name' => 'Pedro',
                'email' => '',
                'password' => '123456',
                'profession' => null
            ])
            ->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['email' => 'El campo correo es obligatorio.']);
        $this->assertEquals(0, User::count());
//        $this->assertDatabaseMissing('users', [
//            'email' => 'duilio@styde.net',
//        ]);
    }

    /** @test */
    function the_email_is_not_valid()
    {
        $this->from(route('users.create'))
            ->post(route('users.store'), [
                'name' => 'Pedro',
                'email' => 'email-no-valido',
                'password' => '123456',
                'profession' => null
            ])
            ->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['email' => 'El email no es valido.']);
        $this->assertEquals(0, User::count());
//        $this->assertDatabaseMissing('users', [
//            'email' => 'duilio@styde.net',
//        ]);
    }

    /** @test */
    function the_email_is_not_unique()
    {
        $user = factory(User::class)->create([
            'name' => 'Pedro Colmenares',
            'email' => 'p3dro.colmenares@gmail.com',
            'password' => '123456',
            'profession_id' => null,
        ]);
        $this->from(route('users.create'))
            ->post(route('users.store'), [
                'name' => 'Pedro Colmenares',
                'email' => 'p3dro.colmenares@gmail.com',
                'password' => '123456',
                'profession' => null
            ])
            ->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['email' => 'El correo ya se encuentra registrado.']);
        $this->assertEquals(1, User::count());
//        $this->assertDatabaseMissing('users', [
//            'email' => 'duilio@styde.net',
//        ]);
    }

    /** @test */
    function the_password_is_required()
    {
        $this->from(route('users.create'))
            ->post(route('users.store'), [
                'name' => 'Pedro',
                'email' => 'pedro@pedro.com',
                'password' => '',
                'profession' => null
            ])
            ->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['password' => 'El campo password es obligatorio.']);
        $this->assertEquals(0, User::count());
//        $this->assertDatabaseMissing('users', [
//            'email' => 'duilio@styde.net',
//        ]);
    }

    /** @test */
    function the_password_is_greater_than_6_characters()
    {
        $this->from(route('users.create'))
            ->post(route('users.store'), [
                'name' => 'Pedro',
                'email' => 'pedro@pedro.com',
                'password' => '123',
                'profession' => null
            ])
            ->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['password' => 'El password debe estar entre 6 y 12 caracteres.']);
        $this->assertEquals(0, User::count());
//        $this->assertDatabaseMissing('users', [
//            'email' => 'duilio@styde.net',
//        ]);
    }

    /** @test */
    function it_loads_the_edit_user_page()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'profession_id' => null,
        ]);
        $this->get("/usuarios/{$user->id}/editar") // usuarios/5/editar
        ->assertStatus(200)
            ->assertViewIs('users.edit')
            ->assertSee('Editar usuario')
            ->assertViewHas('user', function ($viewUser) use ($user) {
                return $viewUser->id === $user->id;
            });

    }

    /** @test */
    function it_update_a_user()
    {
        $user = factory(User::class)->create([
            'profession_id' => null,
        ]);
        $this->withoutExceptionHandling();

        $this->put("/usuarios/{$user->id}", [
            'name' => 'Pedro Colmenares',
            'email' => '9a5e697fed-a05a34@inbox.mailtrap.io',
            'password' => 'colmena3611',
            'profession' => null,
        ])->assertRedirect("/usuarios/{$user->id}");

        $this->assertCredentials([
            'name' => 'Pedro Colmenares',
            'email' => '9a5e697fed-a05a34@inbox.mailtrap.io',
            'password' => 'colmena3611',
            'profession_id' => null,
        ]);

    }

    /** @test */
    function the_name_is_required_update()
    {
        $user = factory(User::class)->create([
            'profession_id' => null,
        ]);
        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => '',
                'email' => 'p3dro.colmenares@gmail.com',
                'password' => '123456',
                'profession' => null
            ])
            ->assertRedirect(url("usuarios/{$user->id}/editar"))
            ->assertSessionHasErrors(['name']);
        $this->assertDatabaseMissing('users', [
            'email' => 'p3dro.colmenares@gmail.com',
        ]);
    }

    /** @test */
    function the_email_is_required_update()
    {
        $user = factory(User::class)->create([
            'profession_id' => null,
        ]);
        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Pedro',
                'email' => '',
                'password' => '123456',
                'profession' => null
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email' => 'El campo correo es obligatorio.']);
        $this->assertDatabaseMissing('users', [
            'name' => 'Pedro',
        ]);
    }

    /** @test */
    function the_email_is_not_valid_update()
    {
        $user = factory(User::class)->create([
            'profession_id' => null,
        ]);
        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Pedro',
                'email' => 'email-no-valido',
                'password' => '123456',
                'profession' => null
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email' => 'El email no es valido.']);
        $this->assertDatabaseMissing('users', [
            'name' => 'Pedro',
        ]);
    }

    /** @test */
    function the_email_must_be_unique_when_updating_the_user()
    {
        //$this->withoutExceptionHandling();
        factory(User::class)->create([
            'email' => 'existing-email@example.com',
            'profession_id' => null,
        ]);
        $user = factory(User::class)->create([
            'email' => 'pedro@pedro.com',
            'profession_id' => null,
        ]);
        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Pedro Colmenares',
                'email' => 'existing-email@example.com',
                'password' => '123456',
                'profession' => null,
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['email']);
        //
    }

    /** @test */
    function the_password_is_optional_update()
    {
        //$this->withoutExceptionHandling();
        $oldPassword = 'clave_anterior';
        $user = factory(User::class)->create([
            'password' => bcrypt($oldPassword),
            'profession_id' => null,

        ]);

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Pedro',
                'email' => 'pedro@pedro.com',
                'password' => '',
                'profession' => null
            ])
            ->assertRedirect("usuarios/{$user->id}");
        $this->assertCredentials([
            'name' => 'Pedro',
            'email' => 'pedro@pedro.com',
            'password' => $oldPassword,
        ]);
    }

    /** @test */
    function the_password_is_greater_than_6_characters_update()
    {

        //$this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'profession_id' => null,
        ]);
        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Pedro Colmenares',
                'email' => 'pedro@pedro.com',
                'password' => '123',
                'profession' => null
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['password' => 'El password debe estar entre 6 y 12 caracteres.']);
        //$this->assertEquals(0, User::count());
        $this->assertDatabaseMissing('users', [
            'email' => 'pedro@pedro.com',
        ]);
    }

    /** @test */
    function the_users_email_can_stay_the_same_when_updating_the_user()
    {
        //$this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'email' => 'pedro@pedro.com',
            'profession_id' => null,
        ]);
        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Pedro Colmenares',
                'email' => 'pedro@pedro.com',
                'password' => '123456',
                'profession' => null,
            ])
            ->assertRedirect("usuarios/{$user->id}"); // (users.show)
        $this->assertDatabaseHas('users', [
            'name' => 'Pedro Colmenares',
            'email' => 'pedro@pedro.com',
        ]);
    }
    /** @test */
    function it_delete_a_user(){
        $this->withoutExceptionHandling();
        $user=factory(User::class)->create([
            'profession_id'=>null,
        ]);
        $this->delete("usuarios/{$user->id}")
            ->assertRedirect('usuarios');
        $this->assertDatabaseMissing('users',[
            'id'=>$user->id,
        ]);
    }
}
