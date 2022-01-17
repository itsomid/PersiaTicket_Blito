<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::whereEmail('persiaticket@seeb.co')->count() > 0)
            return;

        $admin = User::create([
            'first_name' => 'Blito',
            'last_name' => 'Admin',
            'email' => 'Blito@seeb.co',
            'password' => bcrypt('m@u5D7OCOKEdA#rY'),
            'mobile' => '02186128857'
        ]);
        $admin->access_level = 10;
        $admin->status = 'enabled';
        $admin->save();
    }
}
