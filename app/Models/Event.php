<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
    'title', 
    'description',
     'date' ,
      'location' ,
      'type',
       'competences' ,
        'user_id',
    ];
    

 

public function organisator()
{
    return $this->belongsTo(User::class, 'user_id');
}
public function postulations()
{
    return $this->hasMany(Postulation::class, 'event_id');
}   
}
