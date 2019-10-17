<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name' => 'System',                                    'email' => str_replace('@', '+system@', config('custom.mail_owner')),       'passw' => config('custom.pass_owner'), ], 
            ['name' => 'Owner'.config('custom.name_owner'),         'email' => str_replace('@', '+owner@', config('custom.mail_owner')),        'passw' => config('custom.pass_owner'), ], 
            ['name' => 'Developer'.config('custom.name_devel'),     'email' => str_replace('@', '+developer@', config('custom.mail_devel')),    'passw' => config('custom.pass_devel'), ], 
            ['name' => 'Admin'.config('custom.name_owner'),         'email' => str_replace('@', '+admin@', config('custom.mail_owner')),        'passw' => config('custom.pass_owner'), ], 
            ['name' => 'Cmanager'.config('custom.name_owner'),      'email' => str_replace('@', '+cmanager@', config('custom.mail_owner')),     'passw' => config('custom.pass_owner'), ], 
            ['name' => 'Smanager'.config('custom.name_owner'),      'email' => str_replace('@', '+smanager@', config('custom.mail_owner')),     'passw' => config('custom.pass_owner'), ], 
            ['name' => 'Unregistered'.config('custom.name_owner'),  'email' => str_replace('@', '+unregistered@', config('custom.mail_owner')), 'passw' => config('custom.pass_owner'), ], 
            ['name' => 'User1'.config('custom.name_owner'),         'email' => str_replace('@', '+user1@', config('custom.mail_owner')),        'passw' => config('custom.pass_owner'), ], 
            ['name' => 'User1'.config('custom.name_devel'),         'email' => str_replace('@', '+user1@', config('custom.mail_devel')),        'passw' => config('custom.pass_devel'), ], 
        ];

        foreach ( $users as $user ) {
            DB::table('users')->insert([
                'uuid' => Str::uuid(),
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt($user['passw']),
                'status' => 1,
                'verify_token' => Str::random(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
