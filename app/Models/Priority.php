<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;

    protected $table = 'priorities';

    protected $fillable = ['name'];
    public $timestamps = false;
    public function issues()
    {
        return $this->hasMany(Issue::class, 'priority_id');
    }
}
