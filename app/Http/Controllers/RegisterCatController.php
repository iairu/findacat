<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;

class RegisterCatController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new cats as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers; // todo maybe remove

    /**
     * Where to redirect after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register-cat';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }


    public function index()
    {
        if (Auth::user() && Auth::user()->is_admin) {
            return view('cats.register-cat');
        } else {
            return redirect('/');
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'full_name' => 'required|string|max:255',
            'gender_id' => 'required|numeric|in:1,2',
        ]);
    }

    /**
     * Create a new cat instance after a valid registration.
     *
     * @param  array  $data
     * @return Cat
     */
    protected function create(Request $request)
    {
        if (Auth::user() && Auth::user()->is_admin) {
            $cat = Cat::create([
                'id' => Uuid::uuid4()->toString(),
                'titles_before_name' => $request->get('titles_before_name') || "",
                'full_name' => $request->get('full_name'),
                'titles_after_name' => $request->get('titles_after_name') || "",
                'gender_id' => $request->get('gender_id'),
            ]);
            $cat->save();

            return view('cats.register-cat');
        } else {
            return redirect('/');
        }
    }
}
