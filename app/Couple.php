<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Couple extends Model
{
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

    public function husband()
    {
        return $this->belongsTo(Cat::class)->withDefault(['name' => 'N/A']);
    }

    public function wife()
    {
        return $this->belongsTo(Cat::class)->withDefault(['name' => 'N/A']);
    }

    public function childs()
    {
        return $this->hasMany(Cat::class, 'parent_id')->orderBy('birth_order');
    }

    public function addChild(Cat $cat)
    {
        $cat->id = Uuid::uuid4()->toString();
        $cat->parent_id = $this->id;
        $cat->father_id = $this->husband_id;
        $cat->mother_id = $this->wife_id;
        $cat->save();
    }

    public function manager()
    {
        return $this->belongsTo(Cat::class);
    }
}
