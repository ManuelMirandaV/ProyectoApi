<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;
    protected $fillable=[
        'date',
        'reaction_id',
        'user_id',
        'comment'
    ];

    public function user(){
        return $this->belongsTo(User::class);
     }
}
