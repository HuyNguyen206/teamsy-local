<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $tenant = Tenant::factory()->create();
        User::factory()->create(['email' => 'nguyenlehuyuit@gmail.com', 'name' => 'huy', 'tenant_id' => $tenant->id]);
        User::factory(5)->create(['tenant_id' => $tenant->id]);

        Tenant::factory(4)->create()->each(function ($tenant) {
           User::factory(random_int(2, 10))->create(['tenant_id' => $tenant->id]);
        });
    }
}
