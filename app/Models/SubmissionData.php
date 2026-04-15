<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionData extends Model
{
    protected $table = 'submission_data';

    protected $fillable = [
        'submission_id',
        'field_id',
        'value',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function field()
    {
        return $this->belongsTo(FormField::class, 'field_id');
    }
}
