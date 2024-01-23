<?php

namespace App\Http\Controllers;

use App\Cat;

class CatMarriagesController extends Controller
{
    /**
     * Show cat marriage list.
     *
     * @param  \App\Cat  $cat
     * @return \Illuminate\View\View
     */
    public function index(Cat $cat)
    {
        $marriages = $cat->marriages()->with('husband', 'wife')
            ->withCount('childs')->get();

        return view('cats.marriages', compact('cat', 'marriages'));
    }
}
