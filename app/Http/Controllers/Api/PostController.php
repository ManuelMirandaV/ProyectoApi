<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function list(){

        $Posts = Post::all();
        $list =[];

        foreach($Posts as $Post){
            $object = [
                "id" => $Post->id,
                "title" =>$Post->title,
                "date"=>$Post->date,
                "category"=>$Post->category,
                "description"=>$Post->description,
               // "user"=>$Post->user,
            ];
            array_push($list, $object);
        }
        return response()->json($list); 
    }
    public function item($id){

        $Post = Post::where('id','=',$id)->first();

            $object = [
                "id" => $Post->id,
                "title" =>$Post->title,
                "date"=>$Post->date,
                "category"=>$Post->category,
                "description"=>$Post->description,
                "user"=>$Post->user,
            ];
        
        return response()->json($object);
        
    }

    public function general($title){

        $Post = Post::where('title','LIKE', '%'.$title.'%')->get();

            $list = [];

            foreach($Post as $Post){
                $object=
                [
                "id" => $Post->id,
                "title" =>$Post->title,
                "date"=>$Post->date,
                "category"=>$Post->category_id,
                "description"=>$Post->description,
                "user"=>$Post->user_id,
                ];
                array_push($list, $object); 
    };
    return response()->json($list);
}

public function element($user_id) {
    $posts = Post::where('user_id', $user_id)->get();

    $postList = [];
    foreach ($posts as $post) {
        $postItem = [
            "id" => $post->id,
            "title" => $post->title,
            "date" => $post->date,
            "category" => $post->category_id,   
            "description" => $post->description,
            "user" => $post->user_id,
        ];
        array_push($postList, $postItem);
    }

    return response()->json($postList);
}



public function create (Request $request){
    $data = $request->validate([
        "title" => "required",  
        "user_id" => "required|numeric",    
        "date" => "required",   
        "description" => "required",
        "category_id" => "required|numeric",       
  

    ]);

    $post = Post::create([
        "title" => $data["title"],
        "user_id" => $data["user_id"],
        "date" => $data["date"],
        "description" => $data["description"],
        "category_id" => $data["category_id"],          

    ]);

    if($post){
        return response()->json([
            "message" => "Post creado correctamente",
            "data" => $post
        ]);
    }else{
        return response()->json([
            "message" => "Intenta mas tarde"
        ]);
    }}
    public function update(Request $request){
        $data = $request -> validate([
            'id' => 'required',
            'title' => 'required',
            'date' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'user_id' => 'required'
        ]);
        $Post = Post::where('id', '=', $data['id']) ->first();
        
        if($Post){
            $old = $Post;
            $Post->title =$data['title'];
            $Post->date=$data['date'];
            $Post->category_id=$data['category_id'];
            $Post->description=$data['description'];
            $Post->user_id=$data['user_id'];
            if($Post->save()){
                $object = [
                    "response" => 'Success. Item updated correctly.',
                    "old" => $old,
                    "new" => $Post,
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
    public function PostUser($userId){
        $Posts = Post::where('user_id', '=', $userId)->get();
        $PostData = [];

        foreach ($Posts as $Post) {
            $PostData[] = [
                "id" => $Post->id,
                "title" =>$Post->title,
                "date"=>$Post->date,
                "category"=>$Post->category,
                "description"=>$Post->description,
                "user"=>$Post->user,
            ];
        }

        if(!$PostData){
            return response()->json([
                'message' => "Error al obtener los elementos"
            ]);
        }
        return response()->json($PostData
);
}
public function delete($id) {
    $post = Post::find($id);

    if (!$post) {
        return response()->json([
            'message' => 'Error: Element not found.'
        ], 404);
    }

    if ($post->delete()) {
        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    } else {
        return response()->json([
            'message' => 'Error: Something went wrong while deleting the post.'
        ], 500);
    }
}

}