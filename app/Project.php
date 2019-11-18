<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    public static function create($data) {
        $data["created_at"] = now();
        return DB::table('projects')->insert($data);
    }
}
