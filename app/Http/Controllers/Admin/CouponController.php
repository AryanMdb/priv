<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    //  =============== VIEW LIST INDEX =================================================
    public function index(Request $request)
    {
        $allowed = [10, 25, 50, 100];
        $input = (int) $request->input('entries', 10); // Get 'entries' with a default value of 10

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

        $coupon = Coupon::orderBy('id', 'desc')->paginate($entries);
        $categories = Category::active()->get();
        return view('admin.coupon.index', compact('coupon', 'categories'));
    }

    //  =============== CREATE COUPON FORM VIEW =========================================
    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.coupon.create', compact('categories'));
    }

    //  =============== STORE NEW COUPON ================================================
    public function store(Request $request)
    {
        $requestData = $request->all();

        $validator = Validator::make($requestData, [
            'name' => 'required',
            'code' => 'required',
            'discount_value' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $coupon = Coupon::create([
            'name' => $request->name,
            'cat_id' => $request->category_id,
            'code' => $request->code,
            'discount_value' => $request->discount_value,
            'type' => $request->type,
            'expires_at' => $request->expires_at,
        ]);

        if ($coupon) {
            Alert::success('Success', 'Product Created Successfully!');
            return redirect()->route('coupon.index');
        } else {
            Alert::error('Failed', 'Please Try Again!');
            return redirect()->back();
        }
    }

    //  =============== VIEW COUPON DATA  ===============================================
    public function show($id)
    {
        $coupon = Coupon::find($id);
        $categories = Category::active()->get();
        return view('admin.coupon.view', compact('coupon', 'categories'));
    }

    //  =============== EDIT COUPON FORM VIEW ===========================================
    public function edit($id)
    {
        $coupon = Coupon::find($id);
        $categories = Category::active()->get();
        return view('admin.coupon.edit', compact('categories', 'coupon'));
    }

    //  =============== UPDATE COUPON DATA  =============================================
    public function update(Request $request, $id)
    {
        $requestData = $request->all();

        $validator = Validator::make($requestData, [
            'name' => 'required',
            'code' => 'required',
            'discount_value' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $coupon = Coupon::find($id);

        $coupon->update([
            'name' => $request->name,
            'cat_id' => $request->category_id,
            'code' => $request->code,
            'discount_value' => $request->discount_value,
            'type' => $request->type,
            'expires_at' => $request->expires_at,
        ]);

        if ($coupon) {
            Alert::success('Success', 'Coupon Updated Successfully!');
            return redirect()->back();
        } else {
            Alert::error('Failed', 'Please Try Again!');
            return redirect()->back();
        }
    }

    //  =============== DELETE COUPON DATA  =============================================
    public function destroy($id)
    {
        if (isset($id) && !empty($id)) {
            $make = Coupon::find($id);
            if (isset($make)) {
                $make->delete();
                Alert::success('Success', 'Coupon Deleted Successfully!');
                return redirect()->route('coupon.index');
            } else {
                Alert::error('Failed', 'Please Try Again!');
                return redirect()->back();
            }
        } else {
            Alert::error('Failed', 'Please send ID!');
            return redirect()->back();
        }
    }

    //  =============== DELETE COUPON DATA  =============================================
    public function status(Request $request)
    {
        try {
            $requestData = $request->all();
            if (isset($requestData)) {
                $id = $requestData['id'];
                if (isset($requestData['switch'])) {
                    $value = false;
                } else {
                    $value = true;
                }
                $makes = Coupon::find($id);

                $makes->status = $value;
                $makes->save();

                if ($makes) {
                    Alert::success('Success', 'Coupon Status Changed Successfully !');
                    return redirect()->back();
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}

