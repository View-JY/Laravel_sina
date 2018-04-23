<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(100)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());
        
        $user = User::find(1);
        $user->name = 'viewjy';
        $user->email = '1154930416@qq.com';
        $user->password = bcrypt('admin123');
        $user->is_admin = true;
        $user->activated = true;
        $user->save();
    }
}
