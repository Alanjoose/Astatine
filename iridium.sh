#!/bin/bash

action=$1

object=$2

filename=$3

makeObject()
{
if [ $object = "mail" ]

then

echo "<?php

namespace App\Mail;

class $filename extends Mail
{

}

" >> app/Mail/$filename.php

elif [ $object = "model" ]

then

echo "<?php

namespace App\Models;

class $filename extends Model
{

}

" >> app/Models/$filename.php

fi
}

if [ $action = "make" ]
then
    makeObject
fi
