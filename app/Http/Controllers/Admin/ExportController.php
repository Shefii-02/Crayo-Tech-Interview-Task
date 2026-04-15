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

        $submissions = Submission::where('form_id', $form->id)->get();

        $filename = 'form_' . $form->id . '_export.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($submissions, $form) {

            $file = fopen('php://output', 'w');

            // HEADER ROW
            $fieldLabels = $form->fields->pluck('label', 'id');
            fputcsv($file, $fieldLabels->values()->toArray());

            // DATA ROWS
            foreach ($submissions as $sub) {

                $row = [];

                foreach ($fieldLabels as $fieldId => $label) {
                    $value = $sub->data[$fieldId] ?? '';

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
