<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormField;
use Illuminate\Support\Facades\DB;
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

    // ===========================
    // STORE
    // ===========================
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string'
    //     ]);


    //     try {
    //         DB::beginTransaction();

    //         $form = Form::create([
    //             'title' => $request->title,
    //             'created_by' => auth()->id(),
    //             'company_id' => auth()->id(),
    //             'status' => $request->status == 1 ? '1' : '0'
    //         ]);

    //   $i =  0;
    //         foreach ($request->fields as $field) {
    //   $i =  $i + 1;
    //             $form->fields()->create([
    //                 'label'    => $field['label'] ?? '',
    //                 'name'     => Str::slug($field['label'] ?? 'field_' . Str::random(5), '_'),
    //                 'type'     => $field['type'] ?? 'text',
    //                 'required' => isset($field['required']),
    //                 'order'    => $i ?? 0,
    //                 'options'  => !empty($field['options'])
    //                     ? explode(',', $field['options'])
    //                     : null,
    //             ]);
    //         }
    //         DB::commit();
    //         return redirect('/admin/forms')->with('success', 'Form Created');
    //     } catch (\Exception $e) {
    //         dd($e->getMessage());
    //         DB::rollBack();
    //         return back()->with('error', 'Error creating form: ' . $e->getMessage());
    //     }
    // }


    // =========================
    // STORE FORM
    // =========================
    public function store(Request $request)
    {
        // BASIC VALIDATION
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // CREATE FORM
        $form = Form::create([
            'title' => $request->title,
            'created_by'=> auth()->id(),
            'company_id'=> auth()->id(),
            'status' => $request->status ?? 1,
        ]);

        // SAVE FIELDS
        if ($request->fields) {

            foreach ($request->fields as $field) {

                FormField::create([
                    'form_id'   => $form->id,
                    'label'     => $field['label'] ?? '',
                    'type'      => $field['type'] ?? 'text',
                    'required'  => isset($field['required']) ? 1 : 0,
                    'options'   => $this->formatOptions($field['options'] ?? null),
                    'min'       => $field['min'] ?? null,
                    'max'       => $field['max'] ?? null,
                    'order'     => $field['order'] ?? 0,
                    'name'      => $this->generateName($field['label'] ?? ''),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Form created successfully');
    }


    // =========================
    // UPDATE FORM
    // =========================
    public function update(Request $request, $id)
    {


        try {
            DB::beginTransaction();
            $form = Form::findOrFail($id);

            $request->validate([
                'title' => 'required|string|max:255',
            ]);

            // UPDATE FORM
            $form->update([
                'title' => $request->title,
                'status' => $request->status == 1 ? 1 : 0,
            ]);

            // DELETE OLD FIELDS
            $form->fields()->delete();
            $i = 0;
            // SAVE NEW FIELDS
            if ($request->fields) {

                foreach ($request->fields as $field) {
                    $i = $i + 1;
                    $rules = [];

                    if (!empty($field['required'])) {
                        $rules[] = 'required';
                    }

                    if (!empty($field['min'])) {
                        $rules[] = 'min:' . $field['min'];
                    }

                    if (!empty($field['max'])) {
                        $rules[] = 'max:' . $field['max'];
                    }

                    $validationRules = $rules ? implode('|', $rules) : null;
                    $validationRules = !empty($rules) ? implode('|', $rules) : null;
                    FormField::create([
                        'form_id'   => $form->id,
                        'label'     => $field['label'] ?? '',
                        'type'      => $field['type'] ?? 'text',
                        'required'  => isset($field['required']) ? 1 : 0,
                        'options'   => $this->formatOptions($field['options'] ?? null),
                        'validation_rules' => $validationRules,
                        'min'       => $field['min'] ?? null,
                        'max'       => $field['max'] ?? null,
                        'order'     => $i ?? 0,
                        'name'      => $this->generateName($field['label'] ?? ''),
                    ]);
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Form updated successfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return back()->with('error', 'Error updating form: ' . $e->getMessage());
        }
    }


    // =========================
    // FORMAT OPTIONS (dropdown/checkbox)
    // =========================
    private function formatOptions($options)
    {
        if (!$options) return null;

        // Convert "Red, Blue, Green" → array
        $arr = explode(',', $options);

        return array_map(function ($item) {
            return trim($item);
        }, $arr);
    }


    // =========================
    // GENERATE FIELD NAME
    // =========================
    private function generateName($label)
    {
        return strtolower(str_replace(' ', '_', trim($label)));
    }

    public function edit($id)
    {
        $form = Form::with('fields')->findOrFail($id);
        return view('admin.forms.edit', compact('form'));
    }


    // public function update(Request $request, $id)
    // {
    //     $form = Form::findOrFail($id);

    //     $request->validate([
    //         'title' => 'required'
    //     ]);


    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'fields' => 'required|array'
    //     ]);

    //     $form = Form::findOrFail($id);

    //     try {
    //         DB::beginTransaction();

    //         $form->update([
    //             'title' => $request->title,
    //             'status' => $request->status == 1 ? '1' : '0'
    //         ]);

    //         $existingIds = [];
    //         $i =  0;
    //         foreach ($request->fields as $field) {
    //             $i = $i + 1;
    //             $data = [
    //                 'label'    => $field['label'] ?? '',
    //                 'name'     => Str::slug($field['label'] ?? 'field_' . Str::random(5), '_'),
    //                 'type'     => $field['type'] ?? 'text',
    //                 'required' => isset($field['required']),
    //                 'order'    => $i ?? 0,
    //                 'options'  => !empty($field['options'])
    //                     ? explode(',', $field['options'])
    //                     : null,
    //             ];

    //             // UPDATE EXISTING FIELD
    //             if (!empty($field['id'])) {

    //                 $formField = FormField::find($field['id']);

    //                 if ($formField) {
    //                     $formField->update($data);
    //                     $existingIds[] = $formField->id;
    //                 }
    //             } else {
    //                 // CREATE NEW FIELD
    //                 $newField = $form->fields()->create($data);
    //                 $existingIds[] = $newField->id;
    //             }
    //         }

    //         // DELETE REMOVED FIELDS
    //         $form->fields()->whereNotIn('id', $existingIds)->delete();
    //         DB::commit();
    //         return redirect('/admin/forms')->with('success', 'Form Updated');
    //     } catch (\Exception $e) {
    //         dd($e->getMessage());
    //         DB::rollBack();
    //         return back()->with('error', 'Error updating form: ' . $e->getMessage());
    //     }
    // }


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
