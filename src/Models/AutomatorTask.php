<?php

namespace Skillz\Nnpcreusable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutomatorTask extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "processflow_history_id",
        "formbuilder_data_id",
        "entity",
        "entity_id",
        "entity_site_id",
        "user_id",
        "processflow_id",
        "processflow_step_id",
        "assignment_status",
        "task_status",
    ];
}
