<?php

namespace GeniusSystems\Poll\Models;


use Illuminate\Database\Eloquent\Model;

class UserVote extends Model
{
    protected $table = 'user_votes';
    protected $fillable = ['topic_id','question_id','option_id','user_id'];

    public function options(){
        return $this->belongsTo(Options::class,'option_id');
    }
   
    
}