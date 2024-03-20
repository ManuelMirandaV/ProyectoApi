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

Route::get('/categories', [CategoryController::class,'list']);
Route::get('/categories/{id}', [CategoryController::class,'item']);
Route::get('/reactions', [ReactionController::class,'list']);
Route::get('/reactions/{id}', [ReactionController::class,'item']);
Route::get('/comments', [CommentController::class,'list']);
Route::get('/comments/{id}', [CommentController::class,'item']);
Route::get('/posts', [PostController::class,'list']);
Route::get('/posts/{id}', [PostController::class,'item']);

Route::post('/comments/create', [CommentController::class,'create']);
Route::post('/categories/create', [CategoryController::class,'create']);
Route::post('/posts/create', [PostController::class,'create']);
Route::post('authController', [ReactionController::class,'create']);

Route::post('/comments/update', [CommentController::class,'update']);
Route::post('/categories/update', [CategoryController::class,'update']);
Route::post('/posts/update', [PostController::class,'update']);
Route::post('/reactions/update', [ReactionController::class,'update']);

Route::post('/login', [AuthController::class,'login']);
Route::get('/post/general/{title}', [PostController::class,'general']);
Route::get('/post/element/{id}', [PostController::class,'element']);


Route::get('/users',[UserController::class, 'list']);
Route::get('/users/{id}', [UserController::class, 'item']);
Route::post('/users/create',[UserController::class, 'create']);
Route::post('/users/update',[UserController::class, 'update']);

Route::get('/categories/{id}/posts', [CategoryController::class, 'getPostsByCategory']);

Route::get('/post/user/{id}',[PostController::class, 'PostUser']);

