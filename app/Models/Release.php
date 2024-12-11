<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'version', 'description', 'release_date'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
