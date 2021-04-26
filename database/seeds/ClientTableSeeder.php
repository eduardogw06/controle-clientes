<?php

use App\Client;
use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        Client::create([
            'name' => 'Eduardo Guidio Wolf',
            'email' => 'eduardogw06@gmail.com',
            'birthday' => '1998-11-30',
            'user_id' => '1'
        ]);
    }
}
