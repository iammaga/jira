<?php

namespace App\Models;

use Laratrust\Models\Role as LaratrustRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends LaratrustRole
{
    use HasFactory;

    public $guarded = [];

    protected $fillable = ['name', 'display_name', 'description'];

    public function projects()
    {
        return $this->belongsToMany(
            Project::class,
            'project_role',
            config('laratrust.foreign_keys.role'),
            'project_id'
        )->withPivot('permissions');
    }
}
