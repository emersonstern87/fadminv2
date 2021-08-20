<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo("App\Model\Project", 'project_id');
    }
}
