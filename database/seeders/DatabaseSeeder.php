<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // //         // \App\Models\User::factory(10)->create();
          User::updateOrCreate(
                        ['email' => 'superadmin@example.com'], // يمنع التكرار
                        [
                            'name' => 'Anas Rajab',
                            'password' => Hash::make('12345678'),
                            'phone' => '1111111111',
                            'status' => 'active',
                            'gender' => 'm',          // عدل حسب الحاجة
                            'date_of_birth' => '1990-01-01',
                        ]
                    );

        // 1️⃣ أنشئ/اجلب دور super_admin
        // $role = Role::firstOrCreate([
        //     'name' => 'super_admin',
        //     'guard_name' => 'web',
        // ]);

        // // كل الصلاحيات الموجودة (لنفس guard)
        // $permissions = Permission::where('guard_name', 'web')->get();

        // // اربطهم بالدور
        // $user->fin
        // $user->assignRole('super_admin');
        // $role->syncPermissions($permissions);

        // $user = User::find(1);

        // if ($user) {
        //     $user->assignRole('super_admin');

        // }

//         $permissions = [
//             ['name' => 'stripe.view',   'description' => 'عرض '],
//             ['name' => 'stripe.update',  'description' => 'إضافة '],
//             ['name' => 'user_roles.update', 'description' => 'تعديل '],
//             ['name' => 'user_roles.delete', 'description' => 'حذف '],
//             ['name' => 'user_roles.active', 'description' => 'تفعيل أو تعطيل '],
//         ];

//         foreach ($permissions as $p) {
//             Permission::updateOrCreate(
//                 ['name' => $p['name'], 'guard_name' => 'web'],
//                 ['description' => $p['description']]
//             );
        
//             }
    
           $role = Role::firstOrCreate([
    'name' => 'super_admin',
    'guard_name' => 'web'
]);
// $role->syncPermissions(Permission::all());
    $user = User::where('email', 'superadmin@example.com')->first();

if ($user) {
    $user->assignRole($role);
}        

// Permission::firstOrCreate(['name' => 'stripe.view']);
// Permission::firstOrCreate(['name' => 'stripe.update']);

// Role::firstOrCreate(['name' => 'super-admin']);
// $user = User::find(1);
// $user->assignRole('super-admin');




}


}
