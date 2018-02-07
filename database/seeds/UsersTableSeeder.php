<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<Config::get('dev.seed.users'); $i++) {
            $name = $this->random_name();
            DB::table('users')->insert([
                'name' => $name['first'] . ' ' . $name['last'],
                'email' => $name['email'],
                'password' => bcrypt('password'),
            ]);
        }

    }

    private function random_name() {
        $names = array(
            'Christopher',
            'Ryan',
            'Ethan',
            'John',
            'Zoey',
            'Sarah',
            'Michelle',
            'Samantha',
            'Boyd',
            'Chelsea',
            'Steve',
            'Chris',
        );


        $surnames = array(
            'Walker',
            'Thompson',
            'Anderson',
            'Johnson',
            'Tremblay',
            'Peltier',
            'Cunningham',
            'Simpson',
            'Mercado',
            'Sellers',
            'Hemphill',
            'Winfree',
            'Swanson',
            'Chilek'
        );

        $random_name = $names[mt_rand(0, sizeof($names) - 1)];
        $random_surname = $surnames[mt_rand(0, sizeof($surnames) - 1)];
        return [
            'first' => $random_name,
            'last' => $random_surname,
            'email' => 'test+'.$random_name.str_random(5).'@victorycto.com'];
    }
}
