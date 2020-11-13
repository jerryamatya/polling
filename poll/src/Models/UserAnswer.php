<?php

namespace GeniusSystems\Poll\Models;


use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    protected $table = 'user_answers';
    protected $fillable = ['topic_id','question_id','answer','user_id'];

    
}