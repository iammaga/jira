<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueType extends Model
{
    use HasFactory;
    protected $table = 'issue_types';

    protected $fillable = ['name'];
    public $timestamps = false;

    public function issues()
    {
        return $this->hasMany(Issue::class, 'type_id');
    }
}
