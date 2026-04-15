<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormField;
use App\Models\Submission;
use App\Models\SubmissionData;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::latest()->paginate(10);
        return view('admin.forms.index', compact('forms'));
    }

    public function create()
    {
        return view('admin.forms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $form = Form::create([
            'title' => $request->title,
            'created_by' => auth()->id(),
            'company_id' => auth()->id()
        ]);

        foreach ($request->fields as $i => $field) {

            FormField::create([
                'form_id' => $form->id,
                'label' => $field['label'],
                'name' => Str::slug($field['label']),
                'type' => $field['type'],
                'required' => isset($field['required']),
                'options' => isset($field['options']) ? json_encode($field['options']) : null,
                'order' => $i,
            ]);
        }

        return redirect('/admin/forms')->with('success', 'Form created');
    }

    public function show($id)
    {
        $form = Form::with('fields')->findOrFail($id);
        return view('admin.forms.show', compact('form'));
    }





    public function destroy($id)
    {
        Form::findOrFail($id)->delete();
        return back()->with('success', 'Deleted');
    }
}
