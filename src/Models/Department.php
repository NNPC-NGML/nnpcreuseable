<?php

namespace Skillz\Nnpcreusable\Models;

use Skillz\Nnpcreusable\Models\Unit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'id',
        'name',
    ];

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
