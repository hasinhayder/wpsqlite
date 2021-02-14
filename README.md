Console App
===========

If you are trying to create a new Console Application that is distributed as .phar file, this template of files will surely help you make the process a lot easier and faster.

Features
--------

* PSR-4 autoloading compliant structure
* Unit-Testing with PHPUnit
* Comprehensive Guides and tutorial
* Easy PHAR file building process
* Eloquent ORM support
* Powered by Symfony Console
* Easy configuration via .env file


## Build Environment


You need to have docker and docker-compose command installed in your local environment to build a new phar file.<br/>

Put up the server dependencies
```
docker-compose up -d
```

ssh to the container
```
docker-compose exec cli bash
```

execute the build command

```
cd /code
./build.sh
```

The compiled phar file should now be available in  /code/dist/yourapp.phar <br/>
You can then upload it to your web server and let the users download/install it by:

```
wget http://downloads.yourdomain.com/yourapp.phar
sudo mv yourapp.phar  /usr/local/bin/yourapp
chmod +x /usr/local/bin/yourapp
yourapp -V
```

shutdown the containers
```
docker-compose down
```