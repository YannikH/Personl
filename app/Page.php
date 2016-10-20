<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['name', 'template', 'default_language', 'url', 'project_id', 'path'];

    public function project() {
        return $this->hasOne('Project', 'id', 'project_id');
    }

    public function strings() {
        return $this->hasMany('PageString');
    }
}