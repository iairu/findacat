<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class RegisterController extends Controller
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
    protected $redirectTo = '/register';

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
        return view('cats.register');
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
            'nickname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
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
        $cat = Cat::create([
            'id' => Uuid::uuid4()->toString(),
            'nickname' => $request->get('nickname'),
            'name' => $request->get('name'),
            'gender_id' => $request->get('gender_id'),
        ]);
        $cat->save();

        return view('cats.register');
    }
}
