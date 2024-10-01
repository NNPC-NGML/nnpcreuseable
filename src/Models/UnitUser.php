<?php

namespace Skillz\Nnpcreusable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitUser extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "unit_id",
    ];
}
