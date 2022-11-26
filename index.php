<?php

use Engine\Database\DB;

require_once 'kernel.php';

print_r(DB::table('users')->select(['email']));