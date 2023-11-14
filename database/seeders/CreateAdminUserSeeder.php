<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */


     
    public function run()
    {
        User::truncate();

        //Admin Seeder
        $user = User::create([
            'name' => 'LaravelTuts', 
            'email' => 'admin@laraveltuts.com',
            'password' => bcrypt('password'),
            'roles_name' => ['owner'],
            'status' => 'active',
        ]);
      
        $role = Role::create(['name' => 'owner']);
       
        $permissions = Permission::pluck('id','id')->all();
     
        $role->syncPermissions($permissions);
       
        $user->assignRole([$role->id]);
    }
}
