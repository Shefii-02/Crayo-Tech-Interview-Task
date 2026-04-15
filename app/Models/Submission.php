<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'form_id',
        'company_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function data()
    {
    return $this->hasMany(SubmissionData::class, 'submission_id', 'id');
    }


    public function dataWithField()
{
    return $this->hasMany(SubmissionData::class)->with('field');
}
}

