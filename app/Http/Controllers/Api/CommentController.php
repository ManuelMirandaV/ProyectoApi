<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function list()
    {
        $comments = Comment::all();
        $list =[];

        foreach($comments as $comment){
            $object = [
                "id" => $comment->id,
                "reaction" => $comment->reaction,
                "user"=> $comment->user,
                "date" => $comment->date,
                "comment" =>$comment->comment,
                "post_id" => $comment->post_id 
            ];
            array_push($list, $object);
        }
        return response()->json($list);
    }

    public function item($id)
    {
        $comment = Comment::where('id','=',$id)->first();

        $object = [
            "id" => $comment->id,
            "reaction" => $comment->reaction,
            "date" => $comment->date,
            "user"=> $comment->user,
            "comment" =>$comment->comment,
            "post_id" => $comment->post_id 
        ];
        
        return response()->json($object);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'reaction_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'date' => 'required',
            'comment' => 'required|min:3',
            'post_id' => 'required|numeric'
        ]);

        $comment = Comment::create([
            'reaction_id'=>$data['reaction_id'],
            'user_id'=>$data['user_id'],
            'comment'=>$data['comment'],
            'date'=>$data['date'],
            'post_id'=>$data['post_id'] 
        ]);

        if($comment){
            return response()->json([
                'mensaje' => 'Comentario publicado',
                'datos' => $comment
            ]);
        } else {
            return response()->json([
                'mensaje' => 'Comentario no publicado',
            ]);
        }
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'reaction_id' => 'required',
            'user_id' => 'required',
            'date' => 'required',
            'comment' => 'required',
            'post_id' => 'required|numeric'
        ]);

        $comment = Comment::where('id', '=', $data['id'])->first();
        
        if($comment){
            $old = $comment;
            $comment->reaction_id = $data['reaction_id'];
            $comment->comment = $data['comment'];
            $comment->date = $data['date'];
            $comment->user_id = $data['user_id'];
            $comment->post_id = $data['post_id']; 

            if($comment->save()){
                $object = [
                    "respuesta" => 'Éxito. Elemento actualizado correctamente.',
                    "old" => $old,
                    "new" => $comment,
                ];
                return response()->json($object);
            } else {
                $object = [
                    "respuesta" => 'Error: Algo salió mal, por favor inténtalo de nuevo.',
                ];
            }
        } else {
            $object = [
                "respuesta" => 'Error: Elemento no encontrado.',
            ];
            return response()->json($object);
        }
    }
}
