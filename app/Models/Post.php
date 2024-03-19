<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'date',
        'category_id',
        'description',
        'user_id'
    ]; 
    public function post()
    {
        return $this->belongsTo(Post::class);
    } 
    public function Comment()
    {
        return $this->belongsTo(Comment::class);
    } 
    public function category()
    {
        return $this->belongsTo(Category::class);
    } 
    public function User()
    {
        return $this->belongsTo(User::class);
    } 
    public function reaction()  
    {
        return $this->belongsTo(Reaction::class);
    } 

}
