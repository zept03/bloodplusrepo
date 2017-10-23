<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'fname' => 'Bea',
            'lname' => 'Benini',
            'mi' => 'S',
            'gender' => 'Female',
            'bloodType' => 'A+',
            'email' => 'beabenini@gmail.com',
            'contactinfo' => '09554847484',
            'dob' => new Carbon('09/08/77'),
            'status' => 'active',
            'password' => bcrypt('angels'),
            'picture' => 'http://bloodplus.usjr.edu.ph/storage/avatars/profile/woman.png',
            'api_token' => base64_encode('beabenini@gmail.com'.'kixgwapo'),
            'email_token' => base64_encode('beabenini@gmail.com'),
            'address' => '{"place":"Waterfront Cebu City Hotel & Casino, Cebu City, Central Visayas, Philippines","longitude":123.9054173,"latitude":10.3261181}',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
     		]);

         DB::table('users')->insert([
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'fname' => 'Mark',
            'lname' => 'Eintein',
            'mi' => 'S',
            'gender' => 'Male',
            'bloodType' => 'B+',
            'email' => 'mark@gmail.com',
            'contactinfo' => '09554411484',
            'dob' => new Carbon('09/08/87'),
            'status' => 'active',
            'password' => bcrypt('angels'),
            'picture' => 'http://bloodplus.usjr.edu.ph/storage/avatars/profile/man.png',
            'api_token' => base64_encode('mark@gmail.com'.'kixgwapo'),
            'email_token' => base64_encode('mark@gmail.com'),
            'address' => '{"place":"Waterfront Cebu City Hotel & Casino, Cebu City, Central Visayas, Philippines","longitude":123.9054173,"latitude":10.3261181}',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()

        ]);


         DB::table('users')->insert([
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'fname' => 'Jason',
            'lname' => 'Derulo',
            'mi' => 'S',
            'gender' => 'Male',
            'bloodType' => 'AB+',
            'email' => 'jason@gmail.com',
            'contactinfo' => '09554411484',
            'dob' => new Carbon('07/08/97'),
            'status' => 'active',
            'password' => bcrypt('angels'),
            'picture' => 'http://bloodplus.usjr.edu.ph/storage/avatars/profile/man.png',
            'api_token' => base64_encode('jason@gmail.com'.'kixgwapo'),
            'email_token' => base64_encode('jason@gmail.com'),
            'address' => '{"place":"Cabreros Street, Cebu City, Central Visayas, Philippines","longitude":123.8711991,"latitude":10.2859119}',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

         DB::table('users')->insert([
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'fname' => 'Jill',
            'lname' => 'Doe',
            'mi' => 'R',
            'gender' => 'Female',
            'bloodType' => 'O+',
            'email' => 'jill@gmail.com',
            'contactinfo' => '09554156284',
            'dob' => new Carbon('02/18/97'),
            'status' => 'active',
            'password' => bcrypt('angels'),
            'picture' => 'http://bloodplus.usjr.edu.ph/storage/avatars/profile/woman.png',
            'api_token' => base64_encode('jill@gmail.com'.'kixgwapo'),
            'email_token' => base64_encode('jill@gmail.com'),
            'address' => '{"place":"Cabreros Street, Cebu City, Central Visayas, Philippines","longitude":123.8711991,"latitude":10.2859119}',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

         DB::table('users')->insert([
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'fname' => 'Jack',
            'lname' => 'Frost',
            'mi' => 'R',
            'gender' => 'Male',
            'bloodType' => 'A-',
            'email' => 'jack@gmail.com',
            'contactinfo' => '09554156284',
            'dob' => new Carbon('08/18/97'),
            'status' => 'active',
            'password' => bcrypt('angels'),
            'picture' => 'http://bloodplus.usjr.edu.ph/storage/avatars/profile/man.png',
            'api_token' => base64_encode('jack@gmail.com'.'kixgwapo'),
            'email_token' => base64_encode('jack@gmail.com'),
            'address' => '{"place":"Cabreros Street, Cebu City, Central Visayas, Philippines","longitude":123.8711991,"latitude":10.2859119}',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

         DB::table('users')->insert([
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'fname' => 'Rose',
            'lname' => 'Hoop',
            'mi' => 'R',
            'gender' => 'Female',
            'bloodType' => 'AB-',
            'email' => 'rose@gmail.com',
            'contactinfo' => '09554156284',
            'dob' => new Carbon('08/28/97'),
            'status' => 'active',
            'password' => bcrypt('angels'),
            'picture' => 'http://bloodplus.usjr.edu.ph/storage/avatars/profile/woman.png',
            'api_token' => base64_encode('rose@gmail.com'.'kixgwapo'),
            'email_token' => base64_encode('rose@gmail.com'),
            'address' => '{"place":"Cabreros Street, Cebu City, Central Visayas, Philippines","longitude":123.8711991,"latitude":10.2859119}',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

         DB::table('users')->insert([
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'fname' => 'Grass',
            'lname' => 'Hooper',
            'mi' => 'R',
            'gender' => 'Female',
            'bloodType' => 'B-',
            'email' => 'grass@gmail.com',
            'contactinfo' => '09554156284',
            'dob' => new Carbon('08/28/97'),
            'status' => 'active',
            'password' => bcrypt('angels'),
            'picture' => 'http://bloodplus.usjr.edu.ph/storage/avatars/profile/man.png',
            'api_token' => base64_encode('grass@gmail.com'.'kixgwapo'),
            'email_token' => base64_encode('grass@gmail.com'),
            'address' => '{"place":"Cabreros Street, Cebu City, Central Visayas, Philippines","longitude":123.8711991,"latitude":10.2859119}',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

         DB::table('users')->insert([
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'fname' => 'Ken',
            'lname' => 'Tucky',
            'mi' => 'R',
            'gender' => 'Male',
            'bloodType' => 'O-',
            'email' => 'ken@gmail.com',
            'contactinfo' => '09554156284',
            'dob' => new Carbon('08/28/1998'),
            'status' => 'active',
            'password' => bcrypt('angels'),
            'picture' => 'http://bloodplus.usjr.edu.ph/storage/avatars/profile/man.png',
            'api_token' => base64_encode('ken@gmail.com'.'kixgwapo'),
            'email_token' => base64_encode('ken@gmail.com'),
            'address' => '{"place":"Cabreros Street, Cebu City, Central Visayas, Philippines","longitude":123.8711991,"latitude":10.2859119}',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
    }

}
