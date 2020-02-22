<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\User;

class Task extends Model
{
    protected $fillable = [
        'order_id', 'subject', 'title', 'country', 'reference_style', 'reference_number', 'dead_line', 'upload_time', 'deliverable', 'word_count', 'word_distribution', 'case_study', 'user_id', 'description'
    ];

    public function user(){
        return $this->belongsTo('User');
    }

    public function tags(){
        return $this->hasMany('Tag');
    }
    
    public function backups(){
        return $this->hasMany('Backup');
    }

    public function escalations(){
        return $this->hasMany('Escalation');
    }
}
