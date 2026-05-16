<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\emprendedore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmprendedoreController extends Controller
{

    public function index()
    {

        $emprendedores =
        User::with('emprendedor')
        ->where('rol','emprendedor')
        ->get();

        return response()->json([
            "success"=>true,
            "emprendedores"=>$emprendedores
        ]);

    }



    public function show($id)
    {

        $usuario =
        User::with('emprendedor')
        ->findOrFail($id);

        return response()->json($usuario);

    }



    public function store(Request $request)
    {

        $request->validate([

            "nombre"=>"required",
            "apellido"=>"required",

            "email"=>
            "required|email|unique:users",

            "tel"=>"required",

            "password"=>
            "required|confirmed",

            "nombre_marca"=>
            "required"

        ]);


        $usuario =
        User::create([

            "nombre"=>$request->nombre,

            "apellido"=>$request->apellido,

            "email"=>$request->email,

            "tel"=>$request->tel,

            "rol"=>"emprendedor",

            "password"=>
            Hash::make(
            $request->password
            )

        ]);


        emprendedore::create([

            "usuario_id"=>
            $usuario->id,

            "nombre_marca"=>
            $request->nombre_marca

        ]);


        return response()->json([
            "success"=>true
        ]);

    }



    public function update(
        Request $request,
        $id
    ){

        $usuario =
        User::findOrFail($id);


        $request->validate([

            "nombre"=>"required",

            "apellido"=>"required",

            "email"=>[
                "required",
                "email",

                Rule::unique(
                    "users"
                )->ignore(
                    $usuario->id
                )
            ],

            "tel"=>"required",

            "nombre_marca"=>
            "required"

        ]);


        $usuario->update([

            "nombre"=>
            $request->nombre,

            "apellido"=>
            $request->apellido,

            "email"=>
            $request->email,

            "tel"=>
            $request->tel

        ]);


        $usuario
        ->emprendedor
        ->update([

            "nombre_marca"=>
            $request->nombre_marca

        ]);


        return response()->json([
            "success"=>true
        ]);

    }



    public function destroy($id)
    {

        $usuario =
        User::findOrFail($id);

        $usuario
        ->emprendedor()
        ->delete();

        $usuario
        ->delete();


        return response()->json([

            "success"=>true

        ]);

    }

}