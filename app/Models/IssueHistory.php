<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_id', 'field_name', 'old_value', 'new_value', 'changed_by', 'changed_at'
    ];

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
