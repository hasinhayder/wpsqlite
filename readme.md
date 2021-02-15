# WPSQLite

WPSQLite.phar helps you to quickly provision WordPress with SQLite and serve the site using PHP's builtin webserver. No external WebServer like Apache or Nginx and Database Server like MySQL or MariaDB is required. WPSQLite can give you a completely portable installation of WordPress which you can install even in your pendrive and run on *nix based operating systems, or even on Windows. 

WPSQLite is very handy to quickly provision a development setup without worrying much about managing host entries, installing fat dependencies, and allows you to focus more on the  development. 

## Installation
Just open the dist folder, download wpsqlite.phar and put it in your global path or use from local directory, whatever is convenient for you

```sh
php wpsqlite.phar install
```

or if you can give execution permission to wpsqlite.phar, rename it as wpsqlite and put it in your global path (like `/usr/sbin/wpsqlite`) and use it like this 

```sh
wpsqlite install
```

That's all :)

