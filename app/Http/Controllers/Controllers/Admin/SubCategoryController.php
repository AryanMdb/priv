<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use App\Http\Requests\BrandMakeRequest;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $subcategories = SubCategory::orderByRaw('CASE WHEN `order` = 0 THEN 1 ELSE 0 END') // First, group rows with order = 0 at the end
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

            return view('admin.subcategory.index', compact('subcategories'));
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
            $categories = Category::active()->get();
            return view('admin.subcategory.create', compact('categories'));

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
            $requestData = $request->all();
            $validator = Validator::make($requestData, [
                'category_id' => 'required',
                'title' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg|required|max:1024',
            ]);

            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator);

            } elseif (isset($requestData) && !empty($requestData)) {
                $imageName = '';
                if ($request->file('image')) {
                    $imageName = Str::uuid() . '.' . $request->image->extension();
                    $upload_image = $request->image->move(public_path('storage/subcategory'), $imageName);
                }

                $newOrderNumber = 1;
                SubCategory::where('order', '>=', $newOrderNumber)
                ->update([
                    'order' => DB::raw('`order` + 1'),
                    'updated_at' => now(),        
                ]);

                $subcategory = SubCategory::create([
                    'category_id' => $request->category_id ?? '',
                    'title' => $request->title ?? '',
                    'image' => $imageName ?? '',
                    'order' => $newOrderNumber,
                ]);
                if ($subcategory) {
                    Alert::success('Success', 'SubCategory Created Successfully!');
                    return redirect()->route('subcategory.index');
                } else {
                    Alert::error('Failed', 'Plese Try Again!');
                    return redirect()->back();
                }
            } else {
                Alert::error('Failed', 'Plese fill full fields!');
                return redirect()->back();
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
            $subcategory = Subcategory::find($id);
            return view('admin.subcategory.view', compact('subcategory'));
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

            $subcategory = SubCategory::find($id);
            $categories = Category::active()->get();
            return view('admin.subcategory.edit', compact('subcategory', 'categories'));

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
            $requestData = $request->all();
            $validator = Validator::make($requestData, [
                'title' => 'required',
                'category_id' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg|max:1024',
            ]);

            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator);

            } elseif (isset($requestData) && !empty($requestData) && isset($id)) {
                $subcategory = SubCategory::find($id);


                if ($request->file('image')) {
                    $existingImagePath = public_path('storage/subcategory/' . $subcategory->image);

                    if (File::exists($existingImagePath)) {
                        File::delete($existingImagePath);

                    }
                    $imageName = Str::uuid() . '.' . $request->image->extension();
                    $upload_image = $request->image->move(public_path('storage/subcategory/'), $imageName);

                } else {
                    $imageName = $request->old_img;
                }

                $subcategory->update([
                    'category_id' => $request->category_id ?? '',
                    'title' => $request->title ?? '',
                    'image' => $imageName ?? '',
                ]);

                if ($subcategory) {
                    Alert::success('Success', 'SubCategory Updated Successfully!');
                    return redirect()->route('subcategory.index');
                } else {
                    Alert::error('Failed', 'Plese Try Again!');
                    return redirect()->back();
                }
            } else {
                Alert::error('Failed', 'Plese fill full fields!');
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
        try {
            if (isset($id) && !empty($id)) {
                $make = SubCategory::find($id);
                if (isset($make)) {
                    $make->delete();
                    Alert::success('Success', 'SubCategory Deleted Successfully!');
                    return redirect()->route('subcategory.index');
                } else {
                    Alert::error('Failed', 'Plese Try Again!');
                    return redirect()->back();
                }
            } else {
                Alert::error('Failed', 'Plese send ID!');
                return redirect()->back();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * 
     * category status */
    public function status(Request $request)
    {
        try {
            $requestData = $request->all();
            if (isset($requestData)) {
                $id = $requestData['id'];
                if (isset($requestData['switch'])) {
                    $value = true;
                } else {
                    $value = false;
                }
                $makes = SubCategory::find($id);
                $makes->status = $value;
                $makes->save();
                if ($makes) {
                    Alert::success('Success', 'SubCategory Status Changed Successfully !');
                    return redirect()->back();
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function updateOrder(Request $request)
    {
        try {
            $sortedIDs = $request->input('sorted_ids');
            if (empty($sortedIDs)) {
                return response()->json(['success' => false, 'message' => 'No IDs provided.']);
            }

            foreach ($sortedIDs as $index => $id) {
                $order = $index + 1;
                SubCategory::where('id', $id)->update(['order' => $order]);
            }

            return response()->json(['success' => true, 'message' => 'Order updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
