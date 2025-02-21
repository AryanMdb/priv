<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManageForm;
use App\Models\ManageField;
use App\Models\Category;
use RealRashid\SweetAlert\Facades\Alert;

class ManageFormsController extends Controller
{
    public function index(){
        try{
            $manage_forms = ManageForm::latest()->get();
            return view('admin.manage_forms.index', compact('manage_forms'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(){
        try {
            $categories = Category::whereDoesntHave('manageFormCategory')->where('is_show', 1)->active()->get();
            return view('admin.manage_forms.create', compact('categories'));
         
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id){
        try {
            $manage_form = ManageForm::with('manageFields')->find($id);
            return view('admin.manage_forms.show', compact('manage_form'));
         
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(Request $request){
        try {
            $manage_form = ManageForm::create([
                'category_id' => $request->category_id ?? '',
            ]);
    
            if ($manage_form) {
                if ($request->has('input_field') && is_array($request->input_field)) {
                    foreach ($request->input_field as $input) {
                        $manage_field = ManageField::create([
                            'category_id' => $request->category_id ?? '',
                            'manage_form_id' => $manage_form->id,
                            'input_field' => $input,
                        ]);
                    }
                }
    
                Alert::success('Success', 'Form data saved successfully.');
                return redirect()->route('manage_forms.index');
            } else {
                Alert::error('Success', 'Failed to create manage form.');
                return redirect()->back();
            }
        } catch (Exception $e) {
            Alert::error('Success', $e->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id){
        try {
            $manage_form = ManageForm::with('manageFields')->find($id);
            if (!$manage_form) {
                return redirect()->route('manage_forms.index')->with('error', 'Manage form not found.');
            }
            $categories = Category::active()->get();
            $manage_fields = $manage_form->manageFields;

            return view('admin.manage_forms.edit', compact('categories', 'manage_form', 'manage_fields'));
         
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id){
        try {
            $manage_form = ManageForm::find($id);
            $manage_form->category_id = $request->input('category_id', $manage_form->category_id);
            $manage_form->save();

            ManageField::where('manage_form_id', $manage_form->id)->delete();

            if ($request->has('input_field') && is_array($request->input_field)) {
                foreach ($request->input_field as $input) {
                    ManageField::create([
                        'category_id' => $manage_form->category_id,
                        'manage_form_id' => $manage_form->id,
                        'input_field' => $input,
                    ]);
                }
            }
        return redirect()->route('manage_forms.index');
        } catch (Exception $e) {
            Alert::error('Success', $e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $manage_form = ManageForm::find($id);
            ManageField::where('manage_form_id', $manage_form->id)->delete();
            $manage_form->delete();
            Alert::success('Success', ' Record deleted successfully.');
            return redirect()->route('manage_forms.index');
        } catch (Exception $e) {
            Alert::error('Error', $e->getMessage());
            return Redirect::back();
        }
    }
}