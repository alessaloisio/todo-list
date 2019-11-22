<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ListTask;

class Project extends Model
{
    protected $table = 'projects';

    public $timestamps = true;

}
