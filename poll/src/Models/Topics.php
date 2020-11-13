<?php

namespace GeniusSystems\Poll\Models;


use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    protected $table = 'topics';
    protected $fillable = ['name','type','description','image','start_at','expires_at'];

    public function questions(){
        return $this->hasMany(Questions::class,'topic_id')->with('options');
    }
}