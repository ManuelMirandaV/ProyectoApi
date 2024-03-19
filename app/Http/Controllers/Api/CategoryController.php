<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoryController extends Controller
{
    public function getPostsByCategory($id)
    {
        $posts = Post::where('category_id', '=', $id)->get();
        $postsData = [];

        foreach ($posts as $post) {
            $postsData[] = [
                "id" => $post->id,
                "title" =>$post->title,
                "date"=>$post->date,
                "category"=>$post->category,
                "description"=>$post->description,
                "user"=>$post->user,
            ];
        }

        if(!$postsData){
            return response()->json([
                'message' => "Error al obtener los elementos"
            ]);
        }
        return response()->json($postsData
        );
    }
    public function list(){

        $categories = Category::all();
        $list =[];

        foreach($categories as $Category){
            $object = [
                "id" => $Category->id,
                "category" =>$Category->category
            ];
            array_push($list, $object);
        }
        return response()->json($list);
    }
    public function item($id){

        $Category = Category::where('id','=',$id)->first();

            $object = [
                "id" => $Category->id,
                "category" =>$Category->category
            ];
        
        return response()->json($object);
    }
    public function create(Request $request){
        $data = $request->validate([
            'category' => 'required|min:3'
        ]);

        $category = category::create([
            'category'=>$data['category']
        ]);
        if($category){
            return response()->json([
                'message' => 'Category creada',
                'data' => $category
                ]);
        }
        else{
            return response()->json([
                'message' => 'Intentelo mas tarde',
                ]);
        }
    }
    public function update(Request $request){
        $data = $request -> validate([
            'id' => 'required',
            'category' => 'required',
        ]);
        $category = category::where('id', '=', $data['id']) ->first();
        
        if($category){
            $old = $category;
            $category->category =$data['category'];
            if($category->save()){
                $object = [
                    "response" => 'Success. Item updated correctly.',
                    "old" => $old,
                    "new" => $category,
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

