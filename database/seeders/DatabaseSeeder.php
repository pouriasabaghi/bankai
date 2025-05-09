<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        \App\Models\Type::factory(2)->create();
        \App\Models\Service::factory(5)->create();
        \App\Models\Card::factory(2)->create();
        \App\Models\Customer::factory(3)->has(\App\Models\Company::factory(3))->create();
        \App\Models\Contract::factory(3)->create();
    }
}
