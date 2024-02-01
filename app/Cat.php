<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

class Cat extends Model
{
    use Notifiable;

    const METADATA_KEYS = [
        'cemetery_location_name',
        'cemetery_location_address',
        'cemetery_location_latitude',
        'cemetery_location_longitude',
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'full_name',
        'gender_id', 
        'titles_before_name', 'titles_after_name', 'registration_numbers', 'breed',
        'ems_color', 'chip_number', 'genetic_tests', 'dob',
        'father_id', 'mother_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'gender',
    ];

    protected $casts = [
        'couples.pivot.id'  => 'string',
        'wifes.pivot.id'    => 'string',
        'husbands.pivot.id' => 'string',
    ];

    // protected $keyType = 'string';

    public function getGenderAttribute()
    {
        return $this->gender_id == 1 ? trans('app.male_code') : trans('app.female_code');
    }

    public function setFather(Cat $father)
    {
        if ($father->gender_id == 1) {

            if ($father->exists == false) {
                $father->save();
            }

            $this->father_id = $father->id;
            $this->save();

            return $father;
        }

        return false;
    }

    public function setMother(Cat $mother)
    {
        if ($mother->gender_id == 2) {

            if ($mother->exists == false) {
                $mother->save();
            }

            $this->mother_id = $mother->id;
            $this->save();

            return $mother;
        }

        return false;
    }

    public function father()
    {
        return $this->belongsTo(Cat::class);
    }

    public function mother()
    {
        return $this->belongsTo(Cat::class);
    }

    public function childs()
    {
        if ($this->gender_id == 2) {
            return $this->hasMany(Cat::class, 'mother_id');
        }

        return $this->hasMany(Cat::class, 'father_id');
    }

    public function profileLink($type = 'profile')
    {
        $type = ($type == 'chart') ? 'chart' : 'show';
        return link_to_route('cats.'.$type, $this->full_name, [$this->id]);
    }

    public function l()
    {
        return link_to_route('cats.tree', $this->full_name, [$this->id, 5], ['title' => $this->full_name.' ('.$this->gender.')']);
    }

    public function fatherLink()
    {
        return $this->father_id ? link_to_route('cats.show', $this->father->full_name, [$this->father_id]) : null;
    }

    public function motherLink()
    {
        return $this->mother_id ? link_to_route('cats.show', $this->mother->full_name, [$this->mother_id]) : null;
    }

    public function s()
    {
        return $this->father_id ? $this->father : null;
    }

    public function d()
    {
        return $this->mother_id ? $this->mother : null;
    }

    public function wifes()
    {
        return $this->belongsToMany(Cat::class, 'couples', 'husband_id', 'wife_id')->using('App\CouplePivot')->withPivot(['id'])->withTimestamps()->orderBy('marriage_date');
    }

    public function addWife(Cat $wife, $marriageDate = null)
    {
        if ($this->gender_id == 1 && !$this->hasBeenMarriedTo($wife)) {
            $this->wifes()->save($wife, [
                'id'            => Uuid::uuid4()->toString(),
                'marriage_date' => $marriageDate,
            ]);
            return $wife;
        }

        return false;
    }

    public function husbands()
    {
        return $this->belongsToMany(Cat::class, 'couples', 'wife_id', 'husband_id')->using('App\CouplePivot')->withPivot(['id'])->withTimestamps()->orderBy('marriage_date');
    }

    public function addHusband(Cat $husband, $marriageDate = null)
    {
        if ($this->gender_id == 2 && !$this->hasBeenMarriedTo($husband)) {
            $this->husbands()->save($husband, [
                'id'            => Uuid::uuid4()->toString(),
                'marriage_date' => $marriageDate,
            ]);
            return $husband;
        }

        return false;
    }

    public function hasBeenMarriedTo(Cat $cat)
    {
        return $this->couples->contains($cat);
    }

    public function couples()
    {
        if ($this->gender_id == 1) {
            return $this->belongsToMany(Cat::class, 'couples', 'husband_id', 'wife_id')->using('App\CouplePivot')->withPivot(['id'])->withTimestamps()->orderBy('marriage_date');
        }

        return $this->belongsToMany(Cat::class, 'couples', 'wife_id', 'husband_id')->using('App\CouplePivot')->withPivot(['id'])->withTimestamps()->orderBy('marriage_date');
    }

    public function marriages()
    {
        if ($this->gender_id == 1) {
            return $this->hasMany(Couple::class, 'husband_id')->orderBy('marriage_date');
        }

        return $this->hasMany(Couple::class, 'wife_id')->orderBy('marriage_date');
    }

    public function siblings()
    {
        if (is_null($this->father_id) && is_null($this->mother_id) && is_null($this->parent_id)) {
            return collect([]);
        }

        return Cat::where('id', '!=', $this->id)
            ->where(function ($query) {
                if (!is_null($this->father_id)) {
                    $query->where('father_id', $this->father_id);
                }

                if (!is_null($this->mother_id)) {
                    $query->orWhere('mother_id', $this->mother_id);
                }

                if (!is_null($this->parent_id)) {
                    $query->orWhere('parent_id', $this->parent_id);
                }

            })
            ->get();
    }

    public function parent()
    {
        return $this->belongsTo(Couple::class);
    }

    public function manager()
    {
        return $this->belongsTo(Cat::class);
    }

    public function getAgeAttribute()
    {
        $ageDetail = null;
        $yearOnlySuffix = Carbon::now()->format('-m-d');

        if ($this->dob) {
            $ageDetail = Carbon::parse($this->dob)->diffInYears();
        }

        return $ageDetail;
    }

    public function getAgeDetailAttribute()
    {
        $ageDetail = null;
        $yearOnlySuffix = Carbon::now()->format('-m-d');

        if ($this->dob) {
            $ageDetail = Carbon::parse($this->dob)->timespan();
        }

        return $ageDetail;
    }

    public function getAgeStringAttribute()
    {
        return '<div title="'.$this->age_detail.'">'.$this->age.' '.trans_choice('cat.age_years', $this->age).'</div>';
    }

    public function getBirthdayAttribute()
    {
        if (!$this->dob) {
            return;
        }

        $birthdayDate = date('Y').substr($this->dob, 4);
        $birthdayDateClass = Carbon::parse($birthdayDate);

        if (Carbon::parse(date('Y-m-d').' 00:00:00')->gt($birthdayDateClass)) {
            return $birthdayDateClass->addYear();
        }

        return $birthdayDateClass;
    }

    public function getBirthdayRemainingAttribute()
    {
        if ($this->dob) {
            return Carbon::now()->diffInDays($this->birthday, false);
        }
    }

    public function metadata()
    {
        return $this->hasMany(CatMetadata::class, 'cat_id', 'id');
    }

    public function getMetadata($key = null, $defaultValue = null)
    {
        $metadata = $this->metadata;

        if (is_null($key)) {
            $metadataCollection = [];
            foreach ($metadata as $metaKey => $metaValue) {
                $metadataCollection[$metaKey] = $metaValue;
            }

            return collect($metadataCollection);
        }

        $meta = $metadata->filter(function ($meta) use ($key) {
            return $meta->key == $key;
        })->first();

        if ($meta) {
            return $meta->value;
        }

        return $defaultValue;
    }
}
