<?php

namespace GeniusSystems\Poll\Models;


use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'options';

    protected $fillable = [
        'question_id','name'
    ];
    public function votes(){
        return $this->hasMany(UserVote::class,'option_id');
    }

    


}