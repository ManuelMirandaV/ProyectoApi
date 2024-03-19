<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reaction;
use GuzzleHttp\Psr7\Message;

class ReactionController extends Controller
{
    public function list(){

        $Reactions = Reaction::all();
        $list =[];

        foreach($Reactions as $Reaction){
            $object = [
                "id" => $Reaction->id,
                "numero" =>$Reaction->numero
            ];
            array_push($list, $object);
        }
        return response()->json($list);
    }
    public function item($id){

        $Reaction = Reaction::where('id','=',$id)->first();

            $object = [
                "id" => $Reaction->id,
                "numero" =>$Reaction->numero
            ];
        
        return response()->json($object);
    }
    public function create(Request $request){
        $data = $request->validate([
            'numero' => 'required|min:1',
        ]);
        $reaction = reaction::create([
            'numero'=>$data['numero']
        ]);
        if($reaction){
            return response()->json([
                'message' => 'se creo exitosamente',
                'data' => $reaction
                ]);
        }
        else{
            return response()->json([
                'message' => 'Intento fallido, Intentelo mas tarde',
                ]);
        }
        
    }
    public function update(Request $request){
        $data = $request -> validate([
            'id' => 'required',
            'numero' => 'required',
        ]);
        $reaction = Reaction::where('id', '=', $data['id']) ->first();
        
        if($reaction){
            $old = $reaction;
            $reaction->numero =$data['numero'];
            if($reaction->save()){
                $object = [
                    "response" => 'Success. Item updated correctly.',
                    "old" => $old,
                    "new" => $reaction,
                ];
                return response()->json($object);
            }else{
                $object =[
                    "response" => 'Error: Somenthing went wrong, please try again.',
                ];
            }
            
        }else{
            $object =[
                "response" => 'Error: Element not found.',
            ];
            return response()->json($object);
        }
    }
    
}

