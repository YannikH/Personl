<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['user_id', 'name', 'url', 'active', 'main_page'];

    public function user() {
        return $this->hasOne('User');
    }

    public function mainPage() {
        return $this->hasOne('\App\Page', 'id', 'main_page');
    }

    public function pages() {
        return $this->hasMany('\App\Page');
    }

    public function mediaLinks()
    {
        return $this->hasMany('MediaLink');
    }
}