<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Alumno;

class AlumnoApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_all_Alumnos()
    {
        $alumnos = Alumno::factory()->count(10)->create();
        $respuesta = $this->getJson("/api/alumnos");
        $respuesta->assertJsonFragment([
            'nombre' => $alumnos[0]->nombre
        ])
            ->assertJsonFragment([
                'nombre' => $alumnos[1]->nombre
            ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_can_get_one_alumno(): void
    {
        $alumno = alumno::factory()->create();
        $response = $this->getJson("/api/alumnos/$alumno->id");
        $response->assertJsonFragment([
            'nombre' => $alumno->nombre
        ]);
    }

    public function test_can_create_alumno(): void
    {

        $this->postJson(route('alumnos.store', [
            'nombre' => "Pepito de los palotes",
            'password' => bcrypt('12345678'),
            'email' => 'a@a.com'
        ]))->assertJsonFragment([
            'nombre' => "Pepito de los palotes"
        ]);
        $this->assertDatabaseHas('alumnos',
            ['nombre' => "Pepito de los palotes"]
        );
    }

    public function text_can_update_alumno()
    {
        $alumno = alumno::factory()->create();
        $this->patchJson(route("alumnos.update", $alumno), ["nombre" => 'Nombre updated'])
            ->assertJsonFragment([
                'nombre' => 'Nombre updated'
            ]);
    }

    public function test_can_delete()
    {
        $alumno = Alumno::factory()->create();
        $this->deleteJson(route("alumnos.destroy", $alumno))
            ->assertNoContent();

        $this->assertDatabaseCount('alumnos', 0);

    }
}
