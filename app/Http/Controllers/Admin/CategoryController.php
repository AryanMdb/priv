<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use App\Http\Requests\BrandMakeRequest;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $allowed = [10, 25, 50, 100];
            $input = (int) $request->input('entries', 10);

            if (!in_array($input, $allowed)) {
                $closest = null;
                $minDiff = PHP_INT_MAX;
                foreach ($allowed as $value) {
                    $diff = abs($value - $input);
                    if ($diff < $minDiff) {
                        $minDiff = $diff;
                        $closest = $value;
                    } elseif ($diff == $minDiff && $value > $closest) {
                        $closest = $value;
                    }
                }
                $entries = $closest;
            } else {
                $entries = $input;
            }

            $categories = Category::orderByRaw('CASE WHEN `order` = 0 THEN 1 ELSE 0 END')
                ->orderBy('order', 'asc')
                ->orderBy('id', 'desc')
                ->paginate($entries);


            // If categories found, pass them to the view
            return view('admin.category.index', compact('categories'));

        } catch (Exception $e) {
            // Return the exception message if an error occurs
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
            return view('admin.category.create');
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
            $data = $request->all();
            $validator = Validator::make($data, [
                'title' => 'required|unique:categories',
                'image' => 'image|mimes:jpeg,png,jpg|required|max:1024',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            } else {

                if ($request->hasFile('image')) {
                    $imageName = Str::uuid() . '.' . $request->image->extension();
                    $upload_image = $request->image->move(public_path('storage/category'), $imageName);
                } else {
                    $imageName = null;
                }

                $newOrderNumber = 1;
                Category::where('order', '>=', $newOrderNumber)
                    ->update([
                        'order' => DB::raw('`order` + 1'), // Correct update of the `order` column
                        'updated_at' => now(),             // Correct update for `updated_at`
                    ]);

                $time = $data['delivery_time'];
                $formattedTime = date("H:i:s", strtotime($time));
                $categoryArray = [
                    'image' => $imageName,
                    'title' => $data['title'],
                    'is_show' => $data['is_show'] ?? 0,
                    'coming_soon' => $data['coming_soon'] ?? 0,
                    'min_value' => json_encode($data['min_value']) ?? json_encode([]),
                    'max_value' => json_encode($data['max_value']),
                    'delivery_charge' => json_encode($data['delivery_charge']),
                    'order' => $newOrderNumber,
                    'delivery_time' => $formattedTime,

                ];

                Category::create($categoryArray);
                Alert::success('Success', 'Category Created Successfully!');
                return redirect()->route('category.index');
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
            $category = Category::find($id);
            return view('admin.category.view', compact('category'));
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
            if (isset($id) && !empty($id)) {
                $categories = '';
                $category = Category::where('id', $id)->first();
                if (isset($category) && !empty($category)) {
                    $categories = $category;
                    return view('admin.category.edit', compact('categories'));
                } else {
                    Alert::error('Failed', 'Data Not Found.');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'title' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg|max:1024',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            } else {
                $category = Category::find($id);
                if ($request->hasFile('image')) {
                    $existingImagePath = public_path('storage/category/' . $category->image);
                    if (File::exists($existingImagePath)) {
                        File::delete($existingImagePath);
                    }
                    $categoryImg = Str::uuid() . '.' . $request->image->extension();
                    $upload_image = $request->image->move(public_path('storage/category/'), $categoryImg);
                } else {
                    $categoryImg = $request->old_img;
                }
                $time = $request->delivery_time;
                $formattedTime = date("H:i:s", strtotime($time));
                $category->update([
                    'image' => $categoryImg,
                    'title' => $request->title ?? '',
                    'is_show' => $request->is_show ?? 0,
                    'coming_soon' => $request->coming_soon ?? 0,
                    'min_value' => json_encode($request->min_value ?? 0),
                    'max_value' => json_encode($request->max_value ?? 0),
                    'delivery_charge' => json_encode($request->delivery_charge ?? 0),
                    'delivery_time' => $formattedTime ?? null,
                ]);

                Alert::success('Success', 'Category Updated Successfully!');
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
                $make = Category::find($id);
                if (isset($make)) {
                    $make->delete();
                    Alert::success('Success', 'Category Deleted Successfully!');
                    return redirect()->route('category.index');
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
                $makes = Category::find($id);
                $makes->status = $value;
                $makes->save();
                if ($makes) {
                    Alert::success('Success', 'Category Status Changed Successfully !');
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
            $orderData = $request->input('order');

            foreach ($orderData as $item) {
                Category::where('id', $item['id'])->update(['order' => $item['position']]);
            }

            return response()->json(['success' => true, 'message' => 'Order updated successfully.']);
        } catch (\Exception $e) {
            Log::error('Sorting update failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}

