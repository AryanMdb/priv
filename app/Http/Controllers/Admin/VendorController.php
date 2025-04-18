<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(Request $request)
    {
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

        $query = User::where([
            'role' => 'vendor',
            'is_verified' => 1
        ]);

        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $vendors = $query->orderBy('id', 'DESC')->paginate($entries);

        return view('admin.vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('admin.vendors.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3',
                'gender' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg|required',
                'phone' => [
                    'required',
                    'numeric',
                    'digits:10',
                    Rule::unique('users')->where(function ($query) {
                        $query->whereNull('deleted_at')
                            ->where('is_verified', 1);
                    }),
                ],
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            } else {

                $profilePicture = '';
                if ($request->hasFile('image')) {
                    $profilePicture = time() . '.' . $request->image->extension();
                    $image = $request->image->move(public_path('storage/profile_image'), $profilePicture);
                }

                $user = User::create([
                    'name' => $request->name ?? '',
                    'phone' => $request->phone ?? '',
                    'gender' => $request->gender ?? '',
                    'image' => $profilePicture ?? '',
                    'role' => 'vendor',
                    'status' => 1,
                    'is_verified' => 1
                ]);
                if ($user) {
                    return redirect()->route('vendor.index');
                } else {
                    return redirect()->back()->withErrors(['msg' => 'Plese Try after Some time !']);
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
