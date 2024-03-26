<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'organisator_id' ,
         'content' ,
         ];

         public function benevole()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function organisator()
    {
        return $this->belongsTo(User::class, 'organisator_id');
    }
}
