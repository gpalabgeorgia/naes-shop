<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryAddress;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryRecords = [
            ['id' => 1, 'user_id' => 1, 'name' => 'Oleg', 'address' => 'Gotsiridze 3', 'city' => 'Tbilisi', 'state' => 'Georgia', 'country' => 'Georgia', 'pincode' => 1979, 'mobile' => 123456789, 'status' => 1]
        ];
        DeliveryAddress::insert($deliveryRecords);
    }
}
