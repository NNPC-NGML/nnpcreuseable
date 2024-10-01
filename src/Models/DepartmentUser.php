<?php

namespace Skillz\Nnpcreusable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentUser extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "user_id",
        "department_id",
    ];
}
