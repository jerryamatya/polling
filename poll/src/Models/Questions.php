<?php

namespace GeniusSystems\Poll\Models;


use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questions';

    protected $fillable = [
        'topic_id','name','description','image','type'
    ];

    public function options(){
        return $this->hasMany(Options::class,'question_id')->withCount('votes');
    }




}