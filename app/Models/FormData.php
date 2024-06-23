<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_builder_id', 'form_field_answers'
    ];

    protected $casts = [
        'form_field_answers' => 'array'
    ];

    public function formBuilder()
    {
        return $this->belongsTo(FormBuilder::class, 'form_builder_id');
    }
}
