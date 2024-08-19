<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_builder_id',
        'form_field_answers',
        'automator_task_id',
        'process_flow_history_id',
        'entity',
        'entity_id',
        'entity_site_id',
        'user_id',
        'status'
    ];

    protected $casts = [];

    public function formBuilder()
    {
        return $this->belongsTo(FormBuilder::class, 'form_builder_id');
    }
}
