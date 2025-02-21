<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use App\Http\Requests\BrandMakeRequest;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Redirect;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $faqData = '';
            $faq = Faq::orderBy('id', 'ASC')->get();
            if(isset($faq) && !empty($faq))
            {   
                $faqData = $faq;
            } else {
                Alert::error('Failed', 'Registration failed');
                return redirect()->back();
            }
            return view('admin.faq.index', compact('faqData'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view('admin.faq.create');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'question'              => 'required|string|min:3',
                'answer'        => 'required|string|min:10',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors());
            }else{

                $faqData = [
                    'question'        => $request['question'],
                    'answer'  => $request['answer']
                ];
                $faq = Faq::create($faqData);
                if($faq){
                    Alert::success('Success', 'Faq created successfully.');
                    return redirect()->route('faq.index');
                }else{
                    Alert::error('Failed', 'Registration failed');
                    return redirect()->back();
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            if(isset($id))
            {
                $faqData = '';
                $faq = Faq::where('id', $id)->first();
                if(isset($faq))
                {
                    $faqData = $faq;
                }
            }
            return view('admin.faq.view', compact('faqData'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * 
     * Faq page show */
    public function showFaq()
    {
        try {
            $faqData = '';
            $faq = Faq::where('status', '1')->orderBy('id', 'desc')->get();
            if(isset($faq))
            {
                $faqData = $faq;
            }
            return view('cmsPage.faq', compact('faqData'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            if(isset($id) && !empty($id))
            {
                $faqData = '';
                $faq = Faq::where('id',$id)->first();
                if(isset($faq) && !empty($faq))
                {
                    $faqData = $faq;
                }
                return view('admin.faq.edit',compact('faqData'));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'question'              => 'required|string|min:3',
                'answer'        => 'required|string|min: 10',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors());
            }

            if(isset($id) && !empty($id))
            {
                $faq = Faq::find($id);
                if(isset($faq) && !empty($faq))
                {
                    $faq->question = $request['question'];
                    $faq->answer = $request['answer'];
                    $faq->save();
                    Alert::success('Success', 'FAQ Updated Successfully.');
                    return redirect()->route('faq.index');
                }else{
                    Alert::error('Failed', 'Registration failed');
                    return redirect()->back();
                }
            } else {
                Alert::error('Failed', 'Record Not Found.');
                return redirect()->back();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(isset($id) && !empty($id))
        {
            $faqData = Faq::where('id', $id); $faqData->delete();
            if($faqData){
                Alert::success('Success', 'FAQ Deleted Successfully !');
                return redirect()->back();
            }
        } else {
            Alert::error('Failed', 'Item deletion failed');
            return redirect()->back();
        }
    }


    /**
     * 
     * make status */
    public function status(Request $request)
    {
        try {
            $requestData = $request->all();
            if(isset($requestData))
            {
                $id = $requestData['id'];
                if(isset($requestData['switch']))
                {
                    $value = false;
                } else {
                    $value = true;
                }
                $faqData = Faq::find($id);
                $faqData->status = $value;
                $faqData->save();
                if ($faqData) {
                    Alert::success('Success', 'FAQ Status Changed Successfully !');
                    return redirect()->back();
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
