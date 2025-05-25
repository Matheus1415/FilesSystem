<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileSystem extends Model
{
    protected $fillable = [
        'name',
        'type',
        'path'
    ];
}
