<?php
namespace App\Models;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> a61f05776bbafded6a18723e1b2ec7f95ac20997
use Illuminate\Database\Eloquent\Model;

class FormBuilder extends Model
{
<<<<<<< HEAD
=======
    use HasFactory;
>>>>>>> a61f05776bbafded6a18723e1b2ec7f95ac20997
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
<<<<<<< HEAD

    public function formData()
    {
        return $this->hasMany(FormData::class, 'form_builder_id');
    }
=======
>>>>>>> a61f05776bbafded6a18723e1b2ec7f95ac20997
}
