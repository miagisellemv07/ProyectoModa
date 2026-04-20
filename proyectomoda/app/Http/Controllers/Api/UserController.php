<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();

        return response()->json([
            "data" => $user,
            "status" => "success"
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $valideted = $request->validate([
        'nombre'=>'required|min:3|max:30',
        'apellido'=>'required|min:3|max:30',
        'email'=>'required|email',
        'password'=>'required|min:4',
        'tel'=>'required',
        'rol'=>'required',
        ]);
        $user =new User();
        $user->nombre=$request->nombre;
        $user->apellido=$request->apellido;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->tel=$request->tel;
        $user->rol=$request->rol;

        $user->save();

        return response()->json([
            "data"=>$user,
            "status"=>"success"
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $user=User::find($id);
        if($user == null){
            return response()->json([
                "message"=>"Usuario no encontrado",
                "status"=>"Error"
            ],404);
        }
        return response()->json([
            "data"=>$user,
            "status"=>"Success"
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
         $valideted = $request->validate([
        'nombre'=>'required|min:3|max:30',
        'apellido'=>'required|min:3|max:30',
        'email'=>'required|email',
        'password'=>'required|min:4',
        'tel'=>'required',
        'rol'=>'required',
        ]);
        $user = User::find($id);
        $user->nombre=$request->nombre;
        $user->apellido=$request->apellido;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->tel=$request->tel;
        $user->rol=$request->rol;

        $user->save();

        return response()->json([
            "data"=>$user,
            "status"=>"success"
        ],201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
           $user = User::find($id);
        if($user == null){
            return response()->json([
                "error"=>"USUARIO NO ENCONTRADO",
                "status"=>"ERROR"
            ],404);
        }
        $user->delete();
        return response()->json([
            "status"=>"Success",
            "message"=>"Registro eliminado correctamente"
        ],204);
    }
}
