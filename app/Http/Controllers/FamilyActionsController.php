<?php

namespace App\Http\Controllers;

use App\Cat;
use App\Couple;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;

class FamilyActionsController extends Controller
{
    /**
     * Set father for a cat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cat  $cat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setFather(Request $request, Cat $cat)
    {
        $request->validate([
            'set_father_id' => 'nullable',
            'set_father'    => 'required_without:set_father_id|max:255',
        ]);

        if ($request->get('set_father_id')) {
            $cat->father_id = $request->get('set_father_id');
            $cat->save();
        } else {
            $father = new Cat;
            $father->id = Uuid::uuid4()->toString();
            $father->full_name = $request->get('set_father');
            $father->gender_id = 1;

            $cat->setFather($father);
        }

        return back();
    }

    /**
     * Set mother for a cat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cat  $cat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setMother(Request $request, Cat $cat)
    {
        $request->validate([
            'set_mother_id' => 'nullable',
            'set_mother'    => 'required_without:set_mother_id|max:255',
        ]);

        if ($request->get('set_mother_id')) {
            $cat->mother_id = $request->get('set_mother_id');
            $cat->save();
        } else {
            $mother = new Cat;
            $mother->id = Uuid::uuid4()->toString();
            $mother->full_name = $request->get('set_mother');
            $mother->gender_id = 2;

            $cat->setMother($mother);
        }

        return back();
    }

    /**
     * Add child for a cat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cat  $cat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addChild(Request $request, Cat $cat)
    {
        $request->validate([
            'add_child_name'        => 'required|string|max:255',
            'add_child_gender_id'   => 'required|in:1,2',
            'add_child_parent_id'   => 'nullable|exists:couples,id',
        ]);

        $child = new Cat;
        $child->id = Uuid::uuid4()->toString();
        $child->full_name = $request->get('add_child_name');
        $child->gender_id = $request->get('add_child_gender_id');

        \DB::beginTransaction();
        $child->save();

        if ($request->get('add_child_parent_id')) {
            $couple = Couple::find($request->get('add_child_parent_id'));
            $child->father_id = $couple->husband_id;
            $child->mother_id = $couple->wife_id;
            $child->save();
        } else {
            if ($cat->gender_id == 1) {
                $child->setFather($cat);
            } else {
                $child->setMother($cat);
            }

        }

        \DB::commit();

        return back();
    }

    /**
     * Add wife for male cat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cat  $cat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addWife(Request $request, Cat $cat)
    {
        $request->validate([
            'set_wife_id'   => 'nullable',
            'set_wife'      => 'required_without:set_wife_id|max:255',
            'marriage_date' => 'nullable|date|date_format:Y-m-d',
        ]);

        if ($request->get('set_wife_id')) {
            $wife = Cat::findOrFail($request->get('set_wife_id'));
        } else {
            $wife = new Cat;
            $wife->id = Uuid::uuid4()->toString();
            $wife->full_name = $request->get('set_wife');
            $wife->gender_id = 2;
        }

        $cat->addWife($wife, $request->get('marriage_date'));

        return back();
    }

    /**
     * Add husband for female cat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cat  $cat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addHusband(Request $request, Cat $cat)
    {
        $this->validate($request, [
            'set_husband_id' => 'nullable',
            'set_husband'    => 'required_without:set_husband_id|max:255',
            'marriage_date'  => 'nullable|date|date_format:Y-m-d',
        ]);

        if ($request->get('set_husband_id')) {
            $husband = Cat::findOrFail($request->get('set_husband_id'));
        } else {
            $husband = new Cat;
            $husband->id = Uuid::uuid4()->toString();
            $husband->full_name = $request->get('set_husband');
            $husband->gender_id = 1;
        }

        $cat->addHusband($husband, $request->get('marriage_date'));

        return back();
    }

    // /**
    //  * Set parent for a cat.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Cat  $cat
    //  * @return \Illuminate\Http\RedirectResponse
    //  */
    // public function setParent(Request $request, Cat $cat)
    // {
    //     $cat->parent_id = $request->get('set_parent_id');
    //     $cat->save();

    //     return redirect()->route('cats.show', $cat);
    // }
}
