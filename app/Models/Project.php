<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'created_by'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sprints()
    {
        return $this->hasMany(Sprint::class);
    }

    public function releases()
    {
        return $this->hasMany(Release::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public function roles()
    {
        return $this->belongsToMany(
            config('laratrust.models.role'),
            'project_role',
            'project_id',
            config('laratrust.foreign_keys.role')
        )->withPivot('permissions');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user')
            ->withPivot('role_id');
    }
}
