<?php

namespace Skillz\Nnpcreusable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormBuilder extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        'name',
        'json_form',
        'field_structure',
        'access_control',
        'process_flow_id',
        'automator_flow_id',
        'task_id'
    ];

    protected $casts = [
        'field_structure' => 'array',
        'access_control' => 'array'
    ];

    public function formData()
    {
        return $this->hasMany(FormData::class, 'form_builder_id');
    }
}
