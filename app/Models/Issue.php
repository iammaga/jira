<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'sprint_id', 'release_id', 'title', 'description',
        'type_id', 'priority_id', 'status_id', 'assignee_id', 'created_by'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    public function release()
    {
        return $this->belongsTo(Release::class);
    }

    public function type()
    {
        return $this->belongsTo(IssueType::class, 'type_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function history()
    {
        return $this->hasMany(IssueHistory::class);
    }
}
