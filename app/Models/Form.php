<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
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
}
