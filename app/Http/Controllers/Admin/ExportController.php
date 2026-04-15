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
        $request->validate([
            'form_id' => 'required|exists:forms,id'
        ]);

        $form = Form::with('fields')->findOrFail($request->form_id);

        $submissions = Submission::where('form_id', $form->id)
            ->with('data')
            ->get();

        return response()->streamDownload(function () use ($submissions, $form) {

            $file = fopen('php://output', 'w');

            // Header
            $headers = $form->fields->pluck('label')->toArray();
            fputcsv($file, $headers);

            foreach ($submissions as $submission) {

                $row = [];

                foreach ($form->fields as $field) {

                    $value = optional(
                        $submission->data->where('field_id', $field->id)->first()
                    )->value;

                    $row[] = $value;
                }

                fputcsv($file, $row);
            }

            fclose($file);

        }, 'export.csv');
    }
}
