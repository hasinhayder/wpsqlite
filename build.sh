#! /bin/bash

composer install

if [ -f 'dist/*.phar' ];
then
   rm dist/*.phar
fi

box compile
echo 'build complete!'