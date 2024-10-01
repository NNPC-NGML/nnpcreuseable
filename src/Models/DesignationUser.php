<?php

namespace Skillz\Nnpcreusable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignationUser extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "user_id",
        "designation_id",
    ];
}
