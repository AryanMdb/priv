<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserBook;
use App\Models\Media;
use Illuminate\Http\Request;
use App\CustomHelper\Helpers;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use App\Services\GoogleMapsService;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    protected $googleMapsService;

    public function __construct(GoogleMapsService $googleMapsService)
    {
        $this->googleMapsService = $googleMapsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        $users = User::where([
            'role' => 'customer',
            'is_verified' => 1
        ])->orderBy('id', 'DESC')->paginate($entries);

        return view('admin.users.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
                    'role' => 'customer',
                    'status' => 1,
                    'is_verified' => 1
                ]);
                if ($user) {
                    return redirect()->route('user.index');
                } else {
                    return redirect()->back()->withErrors(['msg' => 'Plese Try after Some time !']);
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
        $user = User::find($id);
        $latitude = $user->latitude;
        $longitude = $user->longitude;
        $address = $this->googleMapsService->getAddressFromCoordinates($latitude, $longitude);
        return view('admin.users.show', compact('user', 'address'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return view('admin.users.edit', compact('user'));
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
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'gender' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg',
            'phone' => 'required|numeric|digits:10'

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $user = User::find($id);
        if ($request->hasFile('image')) {

            $existingImagePath = public_path('storage/profile_image/' . $user->image);

            if (File::exists($existingImagePath)) {
                File::delete($existingImagePath);

            }
            $profilePicture = time() . '.' . $request->image->extension();
            $image = $request->image->move(public_path('storage/profile_image'), $profilePicture);

        } else {
            $profilePicture = $request->old_profile;
        }

        $user->update([
            'name' => $request->name ?? '',
            'gender' => $request->gender ?? 'male',
            'image' => $profilePicture ?? '',
        ]);

        Alert::success('Success', 'User Details Update Successfully !');
        return redirect()->route('user.index');
    }


    public function updatePassword(Request $request, $id)
    {
        $data = $request->all();
        $user = User::where('id', $id)->first();
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required',
                'confirm_password' => 'required',

            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            } else if (empty($user)) {
                return redirect()->back()->withErrors(['msg' => 'User not found!']);

            } else {
                $user->password = $data['password'];
                $user->save();
                Alert::success('Success', 'User Password Update Successfully !');
                return redirect()->route('user.index');
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
        // Define the phone number of the protected user
        $protectedUserPhoneNumber = '9024303836';

        $user = User::find($id);
        if ($user) {
            // Check if the user to be deleted has the protected phone number
            if ($user->phone == $protectedUserPhoneNumber) {
                Alert::error('Error', 'This account is fixed and cannot be deleted!');
                return redirect()->back();
            }

            $user->delete();
            Alert::success('Success', 'User Deleted Successfully!');
        } else {
            Alert::error('Error', 'User not found!');
        }
        return redirect()->back();
    }

    /**
     * Switch toggle the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function switchToggle(Request $request)
    {
        try {
            $requestData = $request->all();
            if (isset($requestData)) {
                $id = $requestData['id'];
                if (isset($requestData['switch'])) {
                    $value = $requestData['switch'];
                } else {
                    $value = $requestData['switch'] = '1';
                }
                $slider = User::find($id);
                $slider->status = $value;
                $slider->save();
                if ($slider) {
                    Alert::success('Success', 'User Status Changed Successfully !');
                    return redirect()->back();
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function switchToggleBook(Request $request)
    {
        try {
            $requestData = $request->all();
            if (isset($requestData)) {
                $id = $requestData['id'];

                if (isset($requestData['switch'])) {
                    $value = '1';

                } else {
                    $value = '0';
                }

                $slider = UserBook::find($id);
                $slider->status = $value;
                $slider->save();

                if ($slider) {
                    Alert::success('Success', 'Book Status Changed Successfully !');
                    return redirect()->back();
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
