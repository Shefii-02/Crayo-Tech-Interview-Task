<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Submission;
use App\Models\SubmissionData;
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

        return response()->stream(function () use ($submissions, $form) {

            $file = fopen('php://output', 'w');

            // ✅ KEEP COLLECTION (DON'T convert to array too early)
            $fields = $form->fields->sortBy('order')->values();

            $fieldIds = $fields->pluck('id')->toArray();
            $fieldLabels = $fields->pluck('label')->toArray();

            // HEADER
            fputcsv($file, $fieldLabels);

            foreach ($submissions as $sub) {

                $data = $sub->data()
                    ->get()
                    ->pluck('value', 'field_id')
                    ->toArray();

                $row = [];

                foreach ($fieldIds as $fieldId) {
                    $row[] = $data[$fieldId] ?? '';
                }

                fputcsv($file, $row);
            }

            fclose($file);
        }, 200, $headers);
    }
}
