<?php
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ReactionController;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/Categories', [CategoryController::class,'list']);
Route::get('/Categories/{id}', [CategoryController::class,'item']);
Route::get('/Reactions', [ReactionController::class,'list']);
Route::get('/Reactions/{id}', [ReactionController::class,'item']);
Route::get('/Comments', [CommentController::class,'list']);
Route::get('/Comments/{id}', [CommentController::class,'item']);
Route::get('/Posts', [PostController::class,'list']);
Route::get('/Posts/{id}', [PostController::class,'item']);

Route::post('/Comments/create', [CommentController::class,'create']);
Route::post('/Categories/create', [CategoryController::class,'create']);
Route::post('/Posts/create', [PostController::class,'create']);
Route::post('AuthController', [ReactionController::class,'create']);

Route::post('/Comments/update', [CommentController::class,'update']);
Route::post('/Categories/update', [CategoryController::class,'update']);
Route::post('/Posts/update', [PostController::class,'update']);
Route::post('/Reactions/update', [ReactionController::class,'update']);

Route::post('/login', [AuthController::class,'login']);
Route::get('/Post/general/{title}', [PostController::class,'general']);
Route::get('/Post/element/{id}', [PostController::class,'element']);


Route::get('/users',[UserController::class, 'list']);
Route::get('/users/{id}', [UserController::class, 'item']);
Route::post('/users/create',[UserController::class, 'create']);
Route::post('/users/update',[UserController::class, 'update']);

Route::get('/Categories/{id}/Posts', [CategoryController::class, 'getPostsByCategory']);

Route::get('/post/user/{id}',[PostController::class, 'PostUser']);

