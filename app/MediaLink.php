<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaLink extends Model
{
    protected $fillable = ['name', 'project_id', 'url', 'icon'];

    public function project() {
        return $this->hasOne('Project');
    }
}