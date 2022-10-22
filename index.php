<?php

require 'kernel.php';

$test = shell_exec('vendor/bin/phinx migrate');

print_r("result: $test");