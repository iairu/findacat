<?php

namespace App\Http\Controllers;

use App\Couple;
use App\Http\Requests\Cats\UpdateRequest;
use App\Cat;
use App\Jobs\Cats\DeleteAndReplaceCat;
use App\CatMetadata;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use Storage;

class CatsController extends Controller
{
    /**
     * Search cat by keyword.
     *
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $q = $request->get('q');
        $cats = [];

        if ($q) {
            $cats = Cat::with('father', 'mother')->where(function ($query) use ($q) {
                $query->where('name', 'like', '%'.$q.'%');
                $query->orWhere('nickname', 'like', '%'.$q.'%');
            })
                ->orderBy('name', 'asc')
                ->paginate(24);
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
        $father = $cat->father_id ? $cat->father : null;
        $mother = $cat->mother_id ? $cat->mother : null;

        $fatherGrandpa = $father && $father->father_id ? $father->father : null;
        $fatherGrandma = $father && $father->mother_id ? $father->mother : null;

        $motherGrandpa = $mother && $mother->father_id ? $mother->father : null;
        $motherGrandma = $mother && $mother->mother_id ? $mother->mother : null;

        $childs = $cat->childs;
        $colspan = $childs->count();
        $colspan = $colspan < 4 ? 4 : $colspan;

        $siblings = $cat->siblings();

        return view('cats.chart', compact(
            'cat', 'childs', 'father', 'mother', 'fatherGrandpa',
            'fatherGrandma', 'motherGrandpa', 'motherGrandma',
            'siblings', 'colspan'
        ));
    }

    /**
     * Show cat family tree.
     *
     * @param  \App\Cat  $cat
     * @return \Illuminate\View\View
     */
    public function tree(Cat $cat)
    {
        return view('cats.tree', compact('cat'));
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

        $validTabs = ['death', 'contact_address', 'login_account'];

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
     * @param  \App\Http\Requests\Cats\UpdateRequest  $request
     * @param  \App\Cat  $cat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Cat $cat)
    {
        $catAttributes = $request->validated();
        $cat->update($catAttributes);
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
     * Get Cat list based on gender.
     *
     * @param int $genderId
     *
     * @return \Illuminate\Support\Collection
     */
    private function getPersonList(int $genderId)
    {
        return Cat::where('gender_id', $genderId)->pluck('nickname', 'id');
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
            $catsMariageList[$spouse->pivot->id] = $cat->name.' & '.$spouse->name;
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
            $allMariageList[$couple->id] = $couple->husband->name.' & '.$couple->wife->name;
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
