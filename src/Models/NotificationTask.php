<?php

namespace Skillz\Nnpcreusable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationTask extends Model
{
    use HasFactory;

    const PENDING = 0;
    const DONE = 1;
    protected $guarded = [];
    private $fillable = [
        'id',
        "processflow_history_id",
        "formbuilder_data_id",
        "entity_id",
        "entity_type",
        "user_id",
        "processflow_id",
        "processflow_step_id",
        "title",
        "route",
        "start_time",
        "end_time",
        "task_status",
    ];


    /**
     * Get the user associated with the task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
