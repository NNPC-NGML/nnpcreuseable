<?php

namespace Skillz\Nnpcreusable\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    //public $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'id',
    ];

    public function department(): HasOne
    {
        return $this->hasOne(DepartmentUser::class);
    }

    /**
     * Get the units associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function unit(): HasOne
    {
        return $this->hasOne(UnitUser::class);
    }

    public function location(): HasOne
    {
        return $this->hasOne(LocationUser::class);
    }

    public function designation(): HasOne
    {
        return $this->hasOne(DesignationUser::class);
    }
}
