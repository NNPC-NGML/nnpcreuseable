<?php

namespace Skillz\Nnpcreusable\Models;

use Skillz\Nnpcreusable\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
