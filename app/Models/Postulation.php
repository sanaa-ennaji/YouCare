<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulation extends Model
{
    use HasFactory;

    protected $fillable = [
          'user_id',
          'event_id',
          'status',
          'skills' ,
        ];


        public function benevole()
        {
            return $this->belongsTo(User::class, 'user_id');
        }
    
        public function event()
        {
            return $this->belongsTo(Event::class);
        }

}
