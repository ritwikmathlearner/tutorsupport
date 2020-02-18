<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['tag', 'task_id'];
    public $timestamps = false;

    public function task(){
        return $this->belongsTo('Task');
    }
}
