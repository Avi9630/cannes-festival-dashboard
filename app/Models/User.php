<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    // use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use HasFactory, Notifiable, HasRoles;

    protected $guarded  =   [];

    protected $hidden   =   [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt('$value');
    // }

    // public Function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'user_roles');
    // }

    // public function hasRole($role)
    // {
    //     return $this->roles->contains('name', $role);
    // }

    public function ip(): BelongsTo
    {
        // return $this->belongsTo(IpApplicationForm::class);
        return $this->belongsTo(IpApplicationForm::class, 'client_id');
    }

    public function city(): HasOne
    {
        return $this->hasOne(city::class, 'id', 'city_id');
    }

    // public function product()
    // {
    //     return $this->belongsTo('App\Models\Market\Product');
    // }

    // public function state(){
    // 	return $this->hasOne(State::class,'id','state_id');
    // }

    // public function city(){
    // 	return $this->hasOne(City::class,'id','city_id');
    // }

    public function post()
    {
        return $this->hasOne(Post::class);
    }

    public function assignments()
    {
        return $this->hasMany(AssignToJury::class, 'user_id');
    }

    public function assignedJuries()
    {
        return $this->hasMany(AssignToJury::class, 'asigned_by');
    }

    public function cmotJuryAssigns()
    {
        return $this->hasMany(CmotJuryAssign::class, 'user_id');
    }
}
