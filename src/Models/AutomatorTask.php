<?php

namespace Skillz\Nnpcreusable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutomatorTask extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "title",
        "processflow_history_id",
        "formbuilder_data_id",
        "user_id",
        "processflow_id",
        "processflow_step_id",
        "task_status",
        "entity_id",
        "entity_type",
        "start_time",
        "end_time",
        "route",
        "task_status",
    ];
}
