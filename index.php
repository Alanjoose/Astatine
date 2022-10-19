<?php

use App\Database\DB;
use App\Facades\Mask;

require 'kernel.php';

// DB::table('users')->save(['name' => 'Alan', 'email' => 'alan@test.com', 'password' => Mask::make('password')]);
// $user = DB::table('users')->find(4);

print_r(Mask::check('password', Mask::make('password')));