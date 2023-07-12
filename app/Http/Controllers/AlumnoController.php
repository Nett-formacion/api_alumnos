<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Alumno::take(3)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $alumno = new Alumno($request->input());
        $alumno->password = bcrypt($alumno->password);
        $alumno->save();
        return response()->json($alumno,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumno $alumno)
    {
        return $alumno;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumno $alumno)
    {
        $datos = $request->input();
        $verbo = $request->method();
        if ($verbo === 'PUT') {
            // Actualización total
            $datos['password']= bcrypt ($datos['password']);
            $alumno->update($datos);
        }
        if ($verbo === 'PATCH') {
            foreach ($datos  as $campo => $valor)
                if (!is_null($valor))
                    $alumno->$campo = $valor;
            $alumno->password =$alumno->password!==null?  bcrypt($alumno->password) : $alumno->password;
            $alumno->update();

        }

        return $alumno;


}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return response()->json("null", 204);
        //
    }
}
