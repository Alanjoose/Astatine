<?php

use App\Database\DB;
use App\Providers\DBProvider;

require 'kernel.php';

if(DB::makeRollback()) {
    echo "PASSED";
}
else {
    echo "FAILED";
}
