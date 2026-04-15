<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormField;
use App\Models\Submission;
use App\Models\SubmissionData;

class ImportController extends Controller
{
    // SHOW PAGE
    public function index()
    {
        $forms = Form::all();
        return view('admin.import.index', compact('forms'));
    }

    // PREVIEW CSV
    public function preview(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
            'form_id' => 'required'
        ]);

        $file = fopen($request->file('file'), 'r');

        $headers = fgetcsv($file);

        $valid = [];
        $invalid = [];
        $rowNumber = 1;

        while ($row = fgetcsv($file)) {
            $rowNumber++;

            $data = array_combine($headers, $row);

            $errors = [];

            foreach ($data as $key => $value) {
                if (!$value) {
                    $errors[] = "$key is required";
                }
            }

            if (count($errors)) {
                $invalid[] = [
                    'row' => $rowNumber,
                    'errors' => $errors
                ];
            } else {
                $valid[] = $data;
            }
        }

        return view('admin.import.preview', [
            'valid' => $valid,
            'invalid' => $invalid,
            'form_id' => $request->form_id
        ]);
    }

    // STORE DATA
    public function store(Request $request)
    {
        $form_id = $request->form_id;
        $validData = json_decode($request->valid_data, true);

        if (!$validData) {
            return redirect('/admin/import')->with('error', 'No valid data found');
        }

        foreach ($validData as $row) {

            $submission = Submission::create([
                'form_id' => $form_id,
                'company_id' => auth()->id()
            ]);

            foreach ($row as $key => $value) {

                $field = FormField::where('name', $key)
                    ->where('form_id', $form_id)
                    ->first();

                if ($field) {
                    SubmissionData::create([
                        'submission_id' => $submission->id,
                        'field_id' => $field->id,
                        'value' => $value
                    ]);
                }
            }
        }

        return redirect('/admin/import')->with('success', 'Import successful');
    }
}
