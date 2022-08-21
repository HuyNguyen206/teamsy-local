<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class TenantScopeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_model_has_a_tenant_id_on_the_migration()
    {
        $now = now();
       $this->artisan('make:model Test -m');
       $name = $now->year.'_'.$now->format('m').'_'.$now->format('d')
           .'_'.$now->format('h').$now->format('i').$now->format('s').'_create_tests_table.php';
       $this->assertTrue(File::exists($filePath = database_path("migrations/$name")));
        $this->assertStringContainsString('$table->foreignId(\'tenant_id\')->nullable()->index()->constrained();',
        File::get($filePath));
       File::delete($filePath);
       File::delete(app_path("Models/Test.php"));
    }

    public function test_user_can_only_see_users_in_the_same_tenant()
    {
        $user = User::factory()->create();
        User::factory(10)->create(['tenant_id' => $user->tenant_id]);
        User::factory(15)->create();
        auth()->login($user);
        $this->assertEquals(11, User::count());
    }

    public function test_user_can_only_create_user_in_his_tenant()
    {
        $user = User::factory()->create();
        User::factory(10)->create();
        auth()->login($user);

        $users = User::factory(5)->create();
        $users->each(function ($userV) use($user){
            $this->assertEquals($userV->tenant_id, $user->tenant_id);
        });
    }

    public function test_user_can_only_create_user_in_his_tenant_even_if_other_tenant_is_provided()
    {
        $user = User::factory()->create();
        User::factory(10)->create();
        auth()->login($user);

        $users = User::factory(5)->create([
            'tenant_id' => Tenant::factory()
        ]);
        $users->each(function ($userV) use($user){
            $this->assertEquals($userV->tenant_id, $user->tenant_id);
        });
    }


}
