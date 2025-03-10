<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laratrust\Models\Permission as LaratrustPermission;

class Permission extends LaratrustPermission
{
    use HasFactory;

    public $guarded = [];

    protected $fillable = ['name', 'display_name', 'description'];
}
