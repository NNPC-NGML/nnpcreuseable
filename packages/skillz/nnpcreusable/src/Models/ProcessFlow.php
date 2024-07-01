<?php

namespace Skillz\Nnpcreusable\Models;

use Skillz\Nnpcreusable\Models\ProcessFlowStep;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcessFlow extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'start_step_id',
        'frequency',
        'status',
        'frequency_for',
        'day',
        'week',
    ];
    protected $casts = [
        'status' => 'boolean',
    ];

    public function steps(): HasMany
    {
        return $this->hasMany(ProcessFlowStep::class)->orderBy('id');
    }
}
