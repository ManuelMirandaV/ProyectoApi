<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reaction;
use App\Models\User;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function list(){
        $users = User::all();
        $list = [];

        foreach($users as $user){
            $object = [
                "id" => $user->id,
                "name" => $user->name,
                "email"=> $user->email,
                "created_at" => $user->created_at,
                "email_verified_at" => $user->email_verified_at,
                "updated_at" => $user->updated_at,
            ];
            
            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function item($id){
        $user = User::where('id', '=', $id)->first();
                $object = [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email"=> $user->email,
                    "created_at" => $user->created_at,
                    "email_verified_at" => $user->email_verified_at,
                    "updated_at" => $user->updated_at,
                ];
            return response()->json($object);
    }

    public function update(Request $request){
        $data = $request -> validate([
            'id' => 'required|numeric',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',

        ]);
   
        $user = User::where('id', '=', $data['id'])->first();

        if($user) {
            $old = clone $user;

            $user -> name = $data['name'];
            $user -> email = $data['email'];
            $user -> password = $data['password'];


            if($user->save()){
                return response() ->json([
                    'message' => 'Usuario creada correctamente',
                    'old' => $old,
                    'new' => $user
                ]);
            }else{
                return response() ->json([
                    'message' => 'Error al crear una usuario',
                ]);
            }
        }else{
            return response() ->json([
                'message' => 'Elemento no encontrado',
            ]);
        }
    }

    public function create(Request $request){
        $data = $request -> validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',

        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if($user) {
            return response() ->json([
                'message' => 'Usuario creada correctamente',
                'data' => $user
            ]);

        }else{
            return response() ->json([
                'message' => 'Error al crear un usuario',
            ]);
        }
    }
}