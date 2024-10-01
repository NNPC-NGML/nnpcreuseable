<?php

namespace Skillz\Nnpcreusable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationUser extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "user_id",
        "location_id",
    ];
}
