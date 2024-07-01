<?php

namespace Skillz\Nnpcreusable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessFlowHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        'user_id',
        'task_id',
        'process_flow_id',
        'step_id',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean'
    ];
}
