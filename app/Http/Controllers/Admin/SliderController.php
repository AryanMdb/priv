<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Slider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $sliders = Slider::latest()->get();
            if (isset($sliders) && !empty($sliders)) {
                return view('admin.sliders.index', compact('sliders'));
            } else {
                Alert::error('Failed', 'Data Not Found.');
                return redirect()->back();
            }
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
            return view('admin.sliders.create');
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
        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'title' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:3024',
                
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }else{
                $imageName = '';
                if ($request->hasFile('image')) {
                    $imageName = time().'.'.$request->image->extension();
                    $upload_image = $request->image->move(public_path('storage/slider'), $imageName);
                }

                Slider::create([
                    'title' => $request->title ?? '',
                    'image' => $imageName ?? '',
                ]);
                Alert::success('Success', 'Slider Created Successfully!');
                return redirect()->route('sliders.index');
            }
        }catch (Exception $e) {
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
        //
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
            $slider = Slider::where('id',$id)->first();
            return view('admin.sliders.edit',compact('slider'));
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
        try{
            $slider = Slider::find($id);

            if(isset($slider) && !empty($slider)){
                if ($request->hasFile('image')) {
                    // Delete the existing image
                    if (isset($slider?->image)) {
                        $existingImagePath = public_path('storage/slider/'.$slider?->image);
                        if (File::exists($existingImagePath)) {
                            File::delete($existingImagePath);
                        }
                    }
                    $imageName = time().'.'.$request->image->extension();
                    $image = $request->image->move(public_path('storage/slider'), $imageName);
                }

                $slider->update([
                    'title' => $request->title ?? '',
                    'image' => $imageName ?? '',
                ]);

                Alert::success('Success', 'Slider Updated Successfully.');
                return redirect()->route('sliders.index');
            }else {
                Alert::error('Failed', 'Record Not Found.');
                return redirect()->back();
            }
        }catch (Exception $e) {
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
            $slider = Slider::where('id', $id); 
            $slider->delete();
            if($slider){
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
                    $value = true;
                } else {
                    $value = false;
                }

                $makes = Slider::find($id);
                
                $makes->status = $value;
                $makes->save();

                if ($makes) {
                    Alert::success('Success', 'Slider Status Changed Successfully !');
                    return redirect()->back();
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
