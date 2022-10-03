<?php

use App\Providers\DBProvider;

require 'kernel.php';

print_r(DBProvider::getInstance());