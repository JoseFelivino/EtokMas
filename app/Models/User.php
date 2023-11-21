<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Helpers\General\DateHelper;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $appends = ['isAdmin', 'isEmployee'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'role_id',
        'email',
        'password',
        'address',
        'dob',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' =>  'date:'.DateHelper::USER_DATE_FORMAT,
    ];

    public static function getAllEmployee() {
        return User::whereHas('role', function($query) {
            $query->where('name', 'employee');
        });
    }


    public function role() 
    {
        return $this->belongsTo(Role::class);
    }

    public function golds() 
    {
        return $this->hasMany(Gold::class);
    }

    public function transactionHeaders()
    {
        return $this->hasMany(TransactionHeader::class);
    }

    public function pawnTransactionHeaders()
    {
        return $this->hasMany(PawnTransactionHeader::class);
    }

    public function getIsAdminAttribute() {
        return $this->role->name == 'admin';
    }

    public function getIsEmployeeAttribute() {
        return $this->role->name == 'employee';
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format(DateHelper::USER_FORMAT);
    }
}
