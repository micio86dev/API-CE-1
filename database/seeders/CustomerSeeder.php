<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use app\Models\BaseModel;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Clienti predefiniti
        $customers = [
            ['name' => 'Feltrinelli S.p.A.', 'mine' => null],
            ['name' => 'Mondadori Store', 'mine' => null],
            ['name' => 'Libreria Hoepli', 'mine' => null],
            ['name' => 'Adelphi Edizioni', 'mine' => null],
            ['name' => 'IBS Librerie', 'mine' => null],
            ['name' => 'Magazzino Centrale', 'mine' => 'y'],
            ['name' => 'Deposito Secondario', 'mine' => 'y'],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        // Crea altri 13 clienti random
        Customer::factory(13)->create();
    }
}