<?php

namespace App\Http\Controllers\Admin;

use App\Models\Form;
use App\Models\Submission;
use App\Models\SubmissionData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormPublicController extends Controller
{
    //

    public function publicFormShow($id)
    {
        $form = Form::with('fields')->findOrFail($id);

        return view('admin.forms.public-show', compact('form'));
    }


    public function publicFormSubmit(Request $request, $id)
    {
        $form = Form::with('fields')->findOrFail($id);

        // Dynamic validation
        $rules = [];

        foreach ($form->fields as $field) {
            $rule = [];

            if ($field->required) $rule[] = 'required';
            if ($field->type == 'email') $rule[] = 'email';
            if ($field->type == 'number') $rule[] = 'numeric';

            if ($field->validation_rules) {
                $rule = array_merge($rule, $field->validation_rules);
            }

            $rules[$field->name] = $rule;
        }

        $validated = $request->validate($rules);

        // Save submission
        $submission = Submission::create([
            'form_id' => $form->id,
            'company_id' => $form->company_id
        ]);

        foreach ($validated as $key => $value) {
            $field = $form->fields->where('name', $key)->first();

            SubmissionData::create([
                'submission_id' => $submission->id,
                'field_id' => $field->id,
                'value' => is_array($value) ? json_encode($value) : $value
            ]);
        }

        return back()->with('success', 'Form submitted successfully!');
    }
}
