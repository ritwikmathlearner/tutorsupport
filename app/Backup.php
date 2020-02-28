<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    protected $fillable = [
        'user_id', 'task_id', 'amount', 'backup_given_date', 'description'
    ];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('User');
    }

    public function task(){
        return $this->belongsTo('Task');
    }
}
