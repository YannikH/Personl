<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageString extends Model
{
    protected $fillable = ['name', 'content', 'project_id'];
}