<?php

namespace App\Http\Controllers;

use App\Breed;
use App\Couple;
use App\Http\Requests\Cats\UpdateRequest;
use App\Cat;
use App\Jobs\Cats\DeleteAndReplaceCat;
use App\CatMetadata;
use App\Files;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Storage;
use Illuminate\Support\Facades\DB;

class CatsController extends Controller
{

    use Upload;

    /**
     * Upload cats photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cat  $cat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function photoUpload(Request $request, Cat $cat)
    {
        $request->validate([
            'photo' => 'required|image|max:200',
        ]);

        if (Storage::exists($cat->photo_path)) {
            Storage::delete($cat->photo_path);
        }

        $cat->photo_path = $request->photo->store('images');
        $cat->save();

        return back();
    }

    /**
     * Search cat by keyword.
     *
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $full_name = $request->get('full_name');
        $ems_color = $request->get('ems_color');
        $dob = $request->get('dob');
        $breed = $request->get('breed');
        $reg_num = $request->get('reg_num');
        $kind = $request->get('kind');
        $cats = [];

        if ($kind) {
            if ($full_name || $ems_color || $dob || $breed || $reg_num) {
                $cats = Cat::with('sire', 'dam')->where(function ($query) use ($kind, $full_name, $ems_color, $dob, $breed, $reg_num) {
                    $query->where(array_filter([
                        $full_name ? ['full_name', ($kind == "exact") ? '=' : (($kind == "substring") ? 'like' : 'like'), ($kind == "exact") ? $full_name : (($kind == "substring") ? '%'.$full_name.'%' : '%'.$full_name.'%')] : '',
                        $ems_color ? ['ems_color', ($kind == "exact") ? '=' : (($kind == "substring") ? 'like' : 'like'), ($kind == "exact") ? $ems_color : (($kind == "substring") ? '%'.$ems_color.'%' : '%'.$ems_color.'%')] : '',
                        $dob ? ['dob', ($kind == "exact") ? 'like' : (($kind == "substring") ? '=' : 'like'), ($kind == "exact") ? $dob : (($kind == "substring") ? '%'.$dob.'%' : '%'.$dob.'%')] : '',
                        $breed ? ['breed', ($kind == "exact") ? 'like' : (($kind == "substring") ? '=' : 'like'), ($kind == "exact") ? $breed : (($kind == "substring") ? '%'.$breed.'%' : '%'.$breed.'%')] : '',
                        $reg_num ? ['original_reg_num', 
                                    ($kind == "exact") ? '=' : (($kind == "substring") ? 'like' : 'like'), 
                                    ($kind == "exact") ? $reg_num : (($kind == "substring") ? '%'.$reg_num.'%' : '%'.$reg_num.'%'), "or",
                                    'last_reg_num', 
                                    ($kind == "exact") ? '=' : (($kind == "substring") ? 'like' : 'like'), 
                                    ($kind == "exact") ? $reg_num : (($kind == "substring") ? '%'.$reg_num.'%' : '%'.$reg_num.'%')] : '',
                    ]));
                })
                    ->orderBy('full_name', 'asc')
                    ->paginate(24);
                return view('cats.search', compact('cats'));
            }
        }

        return view('cats.search', compact('cats'));
    }

    /**
     * Display the specified Cat.
     *
     * @param  \App\Cat  $cat
     * @return \Illuminate\View\View
     */
    public function show(Cat $cat)
    {
        $catsMariageList = $this->getCatMariageList($cat);
        $allMariageList = $this->getAllMariageList();
        $malePersonList = $this->getPersonList(1);
        $femalePersonList = $this->getPersonList(2);

        return view('cats.show', [
            'cat'             => $cat,
            'catsMariageList' => $catsMariageList,
            'malePersonList'   => $malePersonList,
            'femalePersonList' => $femalePersonList,
            'allMariageList'   => $allMariageList,
        ]);
    }

    /**
     * Display the cat's family chart.
     *
     * @param  \App\Cat  $cat
     * @return \Illuminate\View\View
     */
    public function chart(Cat $cat)
    {
        $sire = $cat->sire_id ? $cat->sire : null;
        $dam = $cat->dam_id ? $cat->dam : null;

        $sireGrandpa = $sire && $sire->sire_id ? $sire->sire : null;
        $sireGrandma = $sire && $sire->dam_id ? $sire->dam : null;

        $damGrandpa = $dam && $dam->sire_id ? $dam->sire : null;
        $damGrandma = $dam && $dam->dam_id ? $dam->dam : null;

        $childs = $cat->childs;
        $colspan = $childs->count();
        $colspan = $colspan < 4 ? 4 : $colspan;

        $siblings = $cat->siblings();

        return view('cats.chart', compact(
            'cat', 'childs', 'sire', 'dam', 'sireGrandpa',
            'sireGrandma', 'damGrandpa', 'damGrandma',
            'siblings', 'colspan'
        ));
    }

    /**
     * Show cat family tree.
     *
     * @param  \App\Cat  $cat
     * @return \Illuminate\View\View
     */
    public function tree(Cat $cat, int $generations = 5)
    {
        return view('cats.tree', compact('cat', 'generations'));
    }

    /**
     * Show cat family tree.
     *
     * @param  \App\Cat  $cat
     * @return \Illuminate\View\View
     */
    public function test(Cat $cat, Cat $cat2, int $generations = 5)
    {
        $malePersonList = $this->getPersonList(1);
        $femalePersonList = $this->getPersonList(2);
        return view('cats.test', compact('cat', 'cat2', 'generations', 'malePersonList', 'femalePersonList'));
    }

    /**
     * Show cat death info.
     *
     * @param  \App\Cat  $cat
     * @return \Illuminate\View\View
     */
    public function death(Cat $cat)
    {
        $mapZoomLevel = config('leaflet.detail_zoom_level');
        $mapCenterLatitude = $cat->getMetadata('cemetery_location_latitude');
        $mapCenterLongitude = $cat->getMetadata('cemetery_location_longitude');

        return view('cats.death', compact('cat', 'mapZoomLevel', 'mapCenterLatitude', 'mapCenterLongitude'));
    }

    /**
     * Show the form for editing the specified Cat.
     *
     * @param  \App\Cat  $cat
     * @return \Illuminate\View\View
     */
    public function edit(Cat $cat)
    {
        $replacementCats = [];
        if (request('action') == 'delete') {
            $replacementCats = $this->getPersonList($cat->gender_id);
        }

        $validTabs = ['death', 'details'];

        $mapZoomLevel = config('leaflet.zoom_level');
        $mapCenterLatitude = $cat->getMetadata('cemetery_location_latitude');
        $mapCenterLongitude = $cat->getMetadata('cemetery_location_longitude');
        if ($mapCenterLatitude && $mapCenterLongitude) {
            $mapZoomLevel = config('leaflet.detail_zoom_level');
        }
        $mapCenterLatitude = $mapCenterLatitude ?: config('leaflet.map_center_latitude');
        $mapCenterLongitude = $mapCenterLongitude ?: config('leaflet.map_center_longitude');

        return view('cats.edit', compact(
            'cat', 'replacementCats', 'validTabs', 'mapZoomLevel', 'mapCenterLatitude', 'mapCenterLongitude'
        ));
    }

    /**
     * Update the specified Cat in storage.
     *
     * @param  \App\Cat  $cat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Cat $cat)
    {
        $catAttributes = Validator::make($request->all(), [
            'full_name'    => 'sometimes|required|string|max:255',
            'gender_id'   => 'sometimes|required|numeric',
            'dob'         => 'nullable|string|max:255',
            'titles_before_name'     => 'nullable|string|max:255',
            'titles_after_name'     => 'nullable|string|max:255',
            'ems_color'     => 'nullable|string|max:255',
            'breed'     => 'nullable|string|max:255',
            'genetic_tests'     => 'nullable|string|max:255',
            'chip_number'     => 'nullable|string|max:255',
            'breeding_station'     => 'nullable|string|max:255',
            'country_code'     => 'nullable|string|max:255',
            'alternative_name'     => 'nullable|string|max:255',
            'print_name_r1'     => 'nullable|string|max:255',
            'print_name_r2'     => 'nullable|string|max:255',
            'dod'     => 'nullable|string|max:255',
            'original_reg_num'     => 'nullable|string|max:255',
            'last_reg_num'     => 'nullable|string|max:255',
            'reg_num_2'     => 'nullable|string|max:255',
            'reg_num_3'     => 'nullable|string|max:255',
            'notes'     => 'nullable|string|max:255',
            'breeder'     => 'nullable|string|max:255',
            'current_owner'     => 'nullable|string|max:255',
            'country_of_origin'     => 'nullable|string|max:255',
            'country'     => 'nullable|string|max:255',
            'ownership_notes'     => 'nullable|string|max:255',
            'personal_info'     => 'nullable|string|max:255',
            'photo'     => 'sometimes|mimes:jpg,png,jpeg|max:3048',
            'vet_confirmation'     => 'sometimes|mimes:jpg,png,jpeg|max:3048'
        ]);
        $attributes = $request->except('photo', 'vet_confirmation');
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = time().'_photo.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $attributes['photo'] = "/images" . "/" . $name;
        }
        if ($request->hasFile('vet_confirmation')) {
            $image = $request->file('vet_confirmation');
            $name = time().'_vet_confirmation.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $attributes['vet_confirmation'] = "/images" . "/" . $name;
        }
        $cat->update($attributes);
        $catAttributes = collect($catAttributes);

        $this->updateCatMetadata($cat, $catAttributes);

        return redirect()->route('cats.show', $cat->id);
    }

    /**
     * Remove the specified Cat from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cat  $cat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Cat $cat)
    {
        if ($request->has('replace_delete_button')) {
            $attributes = $request->validate([
                'replacement_cat_id' => 'required|exists:cats,id',
            ], [
                'replacement_cat_id.required' => __('validation.cat.replacement_cat_id.required'),
            ]);

            $this->dispatchNow(new DeleteAndReplaceCat($cat, $attributes['replacement_cat_id']));

            return redirect()->route('cats.show', $attributes['replacement_cat_id']);
        }

        $request->validate([
            'cat_id' => 'required',
        ]);

        if ($request->get('cat_id') == $cat->id && $cat->delete()) {
            return redirect()->route('cats.search');
        }

        return back();
    }

    /**
     * Get Cat list based on gender.
     *
     * @param int $genderId
     *
     * @return \Illuminate\Support\Collection
     */
    private function getPersonList(int $genderId)
    {
        // Cat::where('gender_id', $genderId)->pluck('full_name', 'id');
        return Cat::select(DB::raw("CONCAT(titles_before_name,' ',full_name,' ',titles_after_name) AS display_name"),'id')->where('gender_id', $genderId)->pluck('display_name','id');
    }

    /**
     * Get marriage list of a cat.
     *
     * @param \App\Cat $cat
     *
     * @return array
     */
    private function getCatMariageList(Cat $cat)
    {
        $catsMariageList = [];

        foreach ($cat->couples as $spouse) {
            $catsMariageList[$spouse->pivot->id] = $cat->full_name.' & '.$spouse->full_name;
        }

        return $catsMariageList;
    }

    /**
     * Get all marriage list.
     *
     * @return array
     */
    private function getAllMariageList()
    {
        $allMariageList = [];

        foreach (Couple::with('husband', 'wife')->get() as $couple) {
            $allMariageList[$couple->id] = $couple->husband->full_name.' & '.$couple->wife->full_name;
        }

        return $allMariageList;
    }

    private function updateCatMetadata(Cat $cat, Collection $catAttributes)
    {
        foreach (Cat::METADATA_KEYS as $key) {
            if ($catAttributes->has($key) == false) {
                continue;
            }
            $catMeta = CatMetadata::firstOrNew(['cat_id' => $cat->id, 'key' => $key]);
            if (!$catMeta->exists) {
                $catMeta->id = Uuid::uuid4()->toString();
            }
            $catMeta->value = $catAttributes->get($key);
            $catMeta->save();
        }
    }
}
