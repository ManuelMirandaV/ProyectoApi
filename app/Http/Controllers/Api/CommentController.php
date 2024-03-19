<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function list(){

        $Comments = Comment::all();
        $list =[];

        foreach($Comments as $Comment){
            $object = [
                "id" => $Comment->id,
                "date" => $Comment->date,
                "reaction" => $Comment->reaction,
                "user"=> $Comment->user,
                "comment" =>$Comment->comment
            ];
            array_push($list, $object);
        }
        return response()->json($list);
    }
    public function item($id){

        $Comment = Comment::where('id','=',$id)->first();

            $object = [
                "id" => $Comment->id,
                "date" => $Comment->date,
                "reaction" => $Comment->reaction,
                "user"=> $Comment->user,
                "comment" =>$Comment->comment
            ];
        
        return response()->json($object);
    }
    public function create(Request $request){
        $data = $request->validate([
            'date' => 'required|min:3',
            'reaction_id' => 'required|min:1',
            'user_id' => 'required|min:1',
            'comment' => 'required|min:3'     
        ]);
        $comment = comment::create([
            'date'=>$data['date'],
            'reaction_id'=>$data['reaction_id'],
            'user_id'=>$data['user_id'],
            'comment'=>$data['comment']
        ]);
        if($comment){
            return response()->json([
                'message' => 'Commment publicado',
                'data' => $comment
                ]);
        }
        else{
            return response()->json([
                'message' => 'Comment no publicado',
                ]);
        }
    }
    public function update(Request $request){
        $data = $request -> validate([
            'id' => 'required',
            'date' => 'required',
            'reaction_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required',
        ]);
        $Comment = Comment::where('id', '=', $data['id']) ->first();
        
        if($Comment){
            $old = $Comment;
            $Comment->date=$data['date'];
            $Comment->reaction_id=$data['reaction_id'];
            $Comment->comment=$data['comment'];
            $Comment->user_id=$data['user_id'];
            if($Comment->save()){
                $object = [
                    "response" => 'Success. Item updated correctly.',
                    "old" => $old,
                    "new" => $Comment,
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
