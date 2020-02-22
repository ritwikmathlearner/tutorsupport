<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escalation extends Model
{
    protected $fillable = ['task_id', 'escalation_count', 'receive_date_time', 'student_message', 'response_message', 'escalation_upload', 'not_justified'];
    public $timestamps = false;

    public function task(){
        return $this->belongsTo('Task');
    }
}
