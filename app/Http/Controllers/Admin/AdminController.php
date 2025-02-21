<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Redirect;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';
   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {
        $input = $request->all();
   
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if(Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                $this->redirectTo = route('dashboard');
            } elseif ($user->role == 'subadmin') {
                $this->redirectTo = route('dashboard-page');
            }else {
                Auth::logout();
                Alert::error('error', 'Login credentials are wrong.');
                return redirect()->route('admin');
            }
            return redirect($this->redirectTo)->with('user', $user);
        }
        Alert::error('error', 'Login credentials are wrong.');
        return redirect()->route('admin');
        // if(Auth::attempt(['email' => $input['email'], 'password' => $input['password']]))
        // {
        //     $user = Auth::user();
        //     if (auth()->user()->role == 'admin' || auth()->user()->role == 'subadmin') {
        //         $user = auth()->user();
        //         return redirect()->route('dashboard')->with('user', $user);
        //     }else {
        //         Auth::logout();
        //         Alert::error('error', 'Login credentials are wrong.');
        //         return redirect()->route('admin');
        //     }
        // }else{
        //     Alert::error('error', 'Login credentials are wrong.');
        //     return redirect()->route('admin');
        // }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(JWTAuth::user())
        {
            $user = auth()->user();
            return redirect()->route('dashboard')->with('user', $user);
        }
        return view('admin.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        return view('admin.layouts.master');
    }


    public function profile($id)
    {
        try {
            if(isset($id) && !empty($id))
            {
                $userData = User::find($id);
                return view('admin.users.profile', compact('userData'));
            } else {
                Alert::success('Success', 'Please fill required parameter');
                return redirect()->back();
            }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try {
            $userData = JWTAuth::user();
            return json_encode($userData);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * 
     * 
     * auth logout */
    public function logout(Request $request)
    {
        try {
            auth()->guard('admin')->logout();
            session()->flush();
          //  \Session::put('success','You are logout successfully');  
            return redirect('/login');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
