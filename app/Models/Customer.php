<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\General\DateHelper;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'phone_number',
        'dob'  
    ];

    public function transactionHeaders()
    {
        return $this->hasMany(TransactionHeader::class);
    }

    protected $casts = [
        'dob' =>  'date:'.DateHelper::USER_DATE_FORMAT,
    ];

    public function pawnTransactionHeaders()
    {
        return $this->hasMany(PawnTransactionHeader::class);
    }

    public static function getCustomerByName($name) {
        return Customer::where('name', 'like', '%'. $name. '%')
            ->orWhere('phone_number', 'like', '%'. $name. '%')
            ->get();
    }

    public static function getAndSaveNewCustomerInstance(
        $email,
        $name,
        $phoneNumber,
        $dob
    ) {
        $customer = new Customer();
        $customer->email = $email;
        $customer->name = $name;
        $customer->phone_number = $phoneNumber;
        $customer->dob = $dob;

        $customer->save();

        return $customer;
    }

    public function updateCustomer(
        $email,
        $name,
        $phoneNumber,
        $dob
    ) {
        $this->update(
            [
                'email' => $email,
                'name' => $name,
                'phone_number' => $phoneNumber,
                'dob' => $dob
            ]
        );
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
