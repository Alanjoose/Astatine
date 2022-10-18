<?php

use App\Database\DB;

require 'kernel.php';

$arr = ['name' => 'test', 'email' => 'baz@email.com', 'password' => 123456];
print_r(DB::table('users')->update($arr, 5));