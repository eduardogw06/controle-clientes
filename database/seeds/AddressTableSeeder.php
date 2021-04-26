<?php

use App\Address;
use Illuminate\Database\Seeder;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        Address::create([
            'zipcode' => '18808074',
            'address' => 'Rua Anibal Cezário Garcia',
            'number' => '186',
            'neighborhood' => 'Conjunto Habitacional Augusto Morini',
            'city' => 'Piraju',
            'state' => 'SP',
            'client_id' => '1'
        ]);
    }
}
