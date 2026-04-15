<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormField;
use App\Models\Submission;
use App\Models\SubmissionData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ImportController extends Controller
{
    // SHOW PAGE
    public function index()
    {
        $forms = Form::all();
        return view('admin.import.index', compact('forms'));
    }





    public function preview(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
            'form_id' => 'required'
        ]);

        $form = Form::with('fields')->findOrFail($request->form_id);

        $file = fopen($request->file('file'), 'r');

        // ✅ AUTO DETECT DELIMITER
        $firstLine = fgets($file);
        $delimiter = str_contains($firstLine, "\t") ? "\t" : ",";
        rewind($file);

        // ✅ HEADERS
        $headers = fgetcsv($file, 0, $delimiter);

        $valid = [];
        $invalid = [];
        $rowNumber = 1;

        while ($row = fgetcsv($file, 0, $delimiter)) {

            $rowNumber++;

            // ✅ FIX COLUMN COUNT
            if (count($row) != count($headers)) {
                if (count($row) > count($headers)) {
                    $row = array_slice($row, 0, count($headers));
                } else {
                    $row = array_pad($row, count($headers), null);
                }
            }

            $data = array_combine($headers, $row);

            $rules = [];

            foreach ($form->fields as $field) {

                $name = $field->name;
                $fieldRules = [];

                // ✅ FIX OPTIONS (STRING → ARRAY)
                $options = $field->options;

                if (is_string($options)) {
                    $options = explode(',', $options);
                }

                $options = array_map('trim', $options ?? []);

                // REQUIRED
                if ($field->required) {
                    $fieldRules[] = 'required';
                }

                // TYPE
                if ($field->type == 'email') {
                    $fieldRules[] = 'email';
                }

                if ($field->type == 'number') {
                    $fieldRules[] = 'numeric';
                }

                if ($field->type == 'date') {
                    $fieldRules[] = 'date';
                }

                // MIN / MAX
                if ($field->min !== null) {
                    $fieldRules[] = 'min:' . $field->min;
                }

                if ($field->max !== null) {
                    $fieldRules[] = 'max:' . $field->max;
                }

                // ✅ DROPDOWN
                if ($field->type == 'dropdown' && $options) {
                    $fieldRules[] = 'in:' . implode(',', $options);
                }

                // ✅ CHECKBOX
                if ($field->type == 'checkbox') {

                    if (isset($data[$name])) {

                        // support "|" and ","
                        $data[$name] = str_contains($data[$name], ',')
                            ? explode(',', $data[$name])
                            : explode(',', $data[$name]);
                    }

                    $rules[$name] = ['array'];

                    if ($options) {
                        $rules[$name . '.*'] = 'in:' . implode(',', $options);
                    }

                    continue;
                }

                $rules[$name] = $fieldRules;
            }

            // ✅ VALIDATE
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                $invalid[] = [
                    'row' => $rowNumber,
                    'errors' => $validator->errors()->all()
                ];
            } else {
                $valid[] = $data;
            }
        }

        fclose($file);

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

        if (!$validData || !count($validData)) {
            return redirect('/admin/import')->with('error', 'No valid data found');
        }

        DB::beginTransaction();

        try {

            foreach ($validData as $row) {

                // ✅ CREATE SUBMISSION
                $submission = Submission::create([
                    'form_id' => $form_id,
                    'company_id' => auth()->id()
                ]);

                foreach ($row as $key => $value) {

                    $field = FormField::where('name', $key)
                        ->where('form_id', $form_id)
                        ->first();

                    if (!$field) {
                        continue;
                    }

                    // ✅ HANDLE ARRAY (checkbox)
                    if (is_array($value)) {
                        $value = json_encode($value); // store as JSON
                    }

                    SubmissionData::create([
                        'submission_id' => $submission->id,
                        'field_id' => $field->id,
                        'value' => $value
                    ]);
                }
            }

            DB::commit();

            return redirect('/admin/import')->with('success', 'Import successful');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect('/admin/import')->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function downloadSample($form_id)
    {
        $form = Form::with('fields')->findOrFail($form_id);

        $headers = [];
        $sampleRow = [];

        foreach ($form->fields as $field) {

            // HEADER (use field name)
            $headers[] = $field->name;

            // SAMPLE DATA
            switch ($field->type) {

                case 'email':
                    $sampleRow[] = 'user@example.com';
                    break;

                case 'number':
                    $sampleRow[] = '25';
                    break;

                case 'date':
                    $sampleRow[] = now()->format('Y-m-d');
                    break;

                case 'dropdown':
                    $sampleRow[] = $field->options[0] ?? 'Option1';
                    break;

                case 'checkbox':
                    // multiple values
                    $sampleRow[] = ($field->options[0] ?? 'Option1') . ',' . ($field->options[1] ?? 'Option2');
                    break;

                default:
                    $sampleRow[] = 'Sample Text';
            }
        }

        $filename = 'sample_form_' . $form->id . '.csv';

        $handle = fopen('php://temp', 'r+');

        // HEADER
        fputcsv($handle, $headers);

        // SAMPLE ROW
        fputcsv($handle, $sampleRow);

        rewind($handle);

        return response()->streamDownload(function () use ($handle) {
            fpassthru($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
