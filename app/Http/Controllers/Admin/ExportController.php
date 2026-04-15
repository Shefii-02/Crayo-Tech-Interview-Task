<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Submission;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function index()
    {
        $forms = Form::all();
        return view('admin.export.index', compact('forms'));
    }

    public function download(Request $request)
    {
        $form = Form::with('fields')->findOrFail($request->form_id);

        $submissions = Submission::with('data')->where('form_id', $form->id)->get();
        $filename = 'form_' . $form->id . '_export.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($submissions, $form) {

            $file = fopen('php://output', 'w');

            // FIELD MAP (ID => LABEL)
            $fields = $form->fields->sortBy('order');

            $fieldIds = $fields->pluck('id')->toArray();
            $fieldLabels = $fields->pluck('label')->toArray();

            // HEADER
            fputcsv($file, $fieldLabels);

            // DATA ROWS
            foreach ($submissions as $sub) {

                $data = is_array($sub->data)
                    ? $sub->data
                    : json_decode($sub->data, true);

                $row = [];

                foreach ($fieldIds as $fieldId) {

                    $value = $data[$fieldId] ?? '';

                    if (is_array($value)) {
                        $value = implode('|', $value);
                    }

                    $row[] = $value;
                }

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
