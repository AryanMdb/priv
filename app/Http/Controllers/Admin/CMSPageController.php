<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSPage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Redirect;

class CMSPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cmsPages = CMSPage::orderBy('id', 'DESC')->get();
        return view('admin.cmsPage.index', compact('cmsPages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cmsPage.create');
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
                'title'              => 'required|min:3',
                'description'        => 'required',
                // 'icon_image'         => 'required|image|mimes:jpg,png,jpeg|max:2048',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors());
            }else{
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request['title'])));
                $image = '';
                if($request->file('icon_image'))
                {
                    $extension = array('jpeg','jpg','png');
                    $file= $request->file('icon_image');
                    $fileExtension = $file->getClientOriginalExtension();
                    if(in_array($fileExtension, $extension))
                    {                        
                        $rand = rand(10,1000000);
                        $filename= date('YmdHi').$rand.'.'.$fileExtension;
                        $file-> move(public_path('pages/icon'), $filename);
                        $image = $filename;
                    }
                }
                $cmsPageData = [
                    'title'        => $request['title'],
                    'slug'         => $slug,
                    'icon_image'         => $image,
                    'description'  => $request['description']
                ];
                $cmsPage = CMSPage::create($cmsPageData);
                if($cmsPage){
                    Alert::success('Success', 'Cms Page Created Successfully');
                    return redirect()->route('cms.index');
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
    public function show($slug)
    {
        try {
            if(isset($slug))
            {
                $cmsPageData = '';
                $cmsPage = CMSPage::where('slug', $slug)->first();
                if(isset($cmsPage))
                {
                    $cmsPageData = $cmsPage;
                }
            }
            return view('admin.cmsPage.view', compact('cmsPageData'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * 
     * cms web page show */
    public function showPage($slug)
    {
        if(isset($slug))
        {
            $cmsPageData = '';
            $cmsPage = CMSPage::where('slug', $slug)->first();
            if(isset($cmsPage))
            {
                $cmsPageData = $cmsPage;
            }
        }
        return view('cmsPage.index', compact('cmsPageData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(isset($id) && !empty($id))
        {
            $cmsPage = CMSPage::where('id',$id)->first();
            return view('admin.cmsPage.edit',compact('cmsPage'));
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
                'title'              => 'required|min:3',
                'description'        => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors());
            }

            if(isset($id) && !empty($id))
            {
                $cmsPage = CMSPage::find($id);
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request['title'])));
                
                if(isset($cmsPage) && !empty($cmsPage))
                {
                    if($request->file('icon_image'))
                    {
                        $extension = array('jpeg','jpg','png');
                        $file= $request->file('icon_image');
                        $fileExtension = $file->getClientOriginalExtension();
                        if(in_array($fileExtension, $extension))
                        {                        
                            $rand = rand(10,1000000);
                            $filename= date('YmdHi').$rand.'.'.$fileExtension;
                            $file-> move(public_path('pages/icon'), $filename);
                            $image = $filename;
                        }
                    } else {
                        $image = $cmsPage->icon_image;
                    }

                    $cmsPage->title = $request['title'];
                    $cmsPage->slug = $slug;
                    $cmsPage->icon_image = $image;
                    $cmsPage->description = $request['description'];
                    $cmsPage->save();
                    
                    Alert::success('Success', 'CMS Page Updated Successfully.');
                    return redirect()->route('cms.index');
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
            $cmsPage = CMSPage::where('id', $id); $cmsPage->delete();
            if($cmsPage){
                Alert::success('Success', 'Page Deleted Successfully !');
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
                $makes = CMSPage::find($id);

                $makes->status = $value;
                $makes->save();

                if ($makes) {
                    Alert::success('Success', 'CMS Page Status Changed Successfully !');
                    return redirect()->back();
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
