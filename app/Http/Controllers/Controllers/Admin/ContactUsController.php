<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    public function index(){
        try{
            $contacts = ContactUs::latest()->get();
            return view('admin.enquiry.index', compact('contacts'));
        }catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            if(isset($id))
            {
                $contact = ContactUs::find($id);
            }
            return view('admin.enquiry.view', compact('contact'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
