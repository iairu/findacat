<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

class User extends Model
{
    use Notifiable;

    const METADATA_KEYS = [
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
        'id', 'username',
        'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    protected $appends = [
    ];

    protected $casts = [
    ];

    // protected $keyType = 'string';

    public function id()
    {
        return $this->id;
    }

}
