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
}
