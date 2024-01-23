<?php

namespace App\Http\Controllers;

use App\Cat;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $cat = Cat::find(1); // todo: if not exist create

        if($cat == null) {
            return redirect()->route('register');
        }

        $catsMariageList = [];
        foreach ($cat->couples as $spouse) {
            $catsMariageList[$spouse->pivot->id] = $cat->name.' & '.$spouse->name;
        }

        $malePersonList = Cat::where('gender_id', 1)->pluck('nickname', 'id');
        $femalePersonList = Cat::where('gender_id', 2)->pluck('nickname', 'id');

        return view('cats.show', [
            'cat'             => $cat,
            'catsMariageList' => $catsMariageList,
            'malePersonList'   => $malePersonList,
            'femalePersonList' => $femalePersonList,
        ]);
    }
}
