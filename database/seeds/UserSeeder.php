<?php

use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::whereId(1)->first())
    	{
    		$user = new User;
            $user->name = "Administrator";
    		$user->email = "admin@admin.com";
    		$user->password = \Hash::make('admin123');
    		$user->save();
    	}
    }
}
