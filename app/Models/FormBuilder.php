<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormBuilder extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "json_form",
        "process_flow_id",
        "process_flow_step_id",
        "tag_id",
    ];

    protected $casts = [];

    public function formData()
    {
        return $this->hasMany(FormData::class, 'form_builder_id');
    }
}
