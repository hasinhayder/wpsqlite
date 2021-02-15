# WPSQLite

WPSQLite.phar helps you to quickly provision WordPress with SQLite and serve the site using PHP's builtin webserver. No external WebServer like Apache or Nginx and Database Server like MySQL or MariaDB is required. WPSQLite can give you a completely portable installation of WordPress which you can install even in your pendrive and run on *nix based operating systems, or even on Windows. 

WPSQLite is very handy to quickly provision a development setup without worrying much about managing host entries, installing fat dependencies, and allows you to focus more on the  development. 

## Installation & Usage
Just open the [**dist**](https://github.com/hasinhayder/wpsqlite/tree/master/dist) folder, download wpsqlite.phar and put it in your global path or use from local directory, whatever is convenient for you

```sh
php wpsqlite.phar install
```

or if you can give execution permission to wpsqlite.phar, rename it as wpsqlite and put it in your global path (like `/usr/sbin/wpsqlite`) and use it like this 

```sh
wpsqlite install
```

**Very Important: Make sure to stop any running apache/nginx/other process that is listening on your 80 port first**

That's all :)

## Pre Requirement (*nix based OS / Linux or Mac)
Two extensions, pdo_sqlite and curl extension must be enabled. If you're using *nix based operating systems (Linux, Mac) then just open your php.ini and uncomment the line where it says ```;extension=pdo_sqlite```. Uncomment = remove the semicolon from the beginning of that line, so make it look like ```extension=pdo_sqlite```. 

Please also uncomment ```;extension=sqlite3``` and make it look like ```extension=sqlite3```.

Also enable curl. Look for the line ```;extension=curl``` and enable it like this ```extension=curl```

You may need to install sqlite library for your PHP version, for example if you have php8, you may need to install it like this on debian/debian-variants

```sh
sudo apt install php8.0-sqlite3
```
## Pre Requirement (Windows)

If you are using windows, open your php.ini and uncomment the line where it says ```;extension=pdo_sqlite.dll```, just change it to ```extension=pdo_sqlite.dll``` and you're ready.

Also enable curl, Look for the line ```;extension=curl.dll``` and enable it like this ```extension=curl.dll```

Please also uncomment ```;extension=sqlite3.dll``` and make it look like ```extension=sqlite3.dll```.
## Create a new site

```sh
php wpsqlite.phar install
```
or 

```sh
wpsqlite.phar install
```

## Run a previously installed site
```sh
php wpsqlite.phar start <sitename>
php wpsqlite.phar start abcd.wplocal.xyz
```
or 

```sh
wpsqlite.phar start <sitename>
wpsqlite.phar start abcd.wplocal.xyz
```

## Post Installation Requirement
**Important**

If you want to install plugins and themes in your freshly installed WordPress site from the admin panel, just open your `wp-config.php` and add the following line

```php
define ('FS_METHOD', 'direct');
```

## History
ওয়ার্ডপ্রেস উইথ এস্কিউলাইট (WordPress With SQLite)

গতকাল সারাদিন আমি একটা ইন্টারেস্টিং প্রজেক্ট নিয়ে কাজ করেছি, সেটা হলো ওয়ার্ডপ্রেস উইথ এস্কিউলাইট। আপনারা জানেন যে ওয়ার্ডপ্রেসের ডেটা স্টোর করতে হলে মাইসিকুয়েল ডেটাবেজ প্রয়োজন ডিফল্টভাবে, সেখানে আপনি চাইলেও অন্য আরডিবিএমএস ব্যবহার করতে পারবেন না। অথচ এস্কিউলাইট ব্যবহার করতে পারলে কত্ত ভালো হতো - আপনার মেশিনে আলাদাভাবে ওয়েবসার্ভার বা মাইসিকুয়েল ইনস্টল করা লাগতো না, হোস্ট কনফিগারেশন করা লাগতো না, আপনার পুরো সেটাপটা পোর্টেবল হয়ে যেত - ইনফ্যাক্ট আপনি পেনড্রাইভে একটা পুরোপুরি ফাংশনাল ওয়ার্ডপ্রেস সেটআপ পকেটে নিয়ে ঘুরে বেড়াতে পারতেন, যেকোনো মেশিনে লাগিয়ে সেখানেই ডেভেলপমেন্টের কাজ করতে পারতেন - সুবিধার শেষ নাই, জাস্ট প্লাগ এন্ড প্লে টাইপের ব্যাপারস্যাপার।

ফার ফাইল টা গ্লোবাল পাথে রাখেন বা লোকাল পাথে - এরপর কমান্ড দেন এটা ’php wpsqlite.phar install’, ব্যাস আপনার পোর্টেবল ওয়ার্ডপ্রেস সেটআপ উইথ এস্কিউলাইট একদম রেডি। এখন পেনড্রাইভেও ওয়ার্ডপ্রেস ইনস্টলেশন পসিবল। ইনস্টল করবেন, পকেটে নিয়ে ঘুরে বেড়াবেন, যেখানে ইচ্ছা, যেই মেশিনে ইচ্ছা সেখানে বসে কাজ করবেন, কি মজা না?

তাহলে ঝামেলা কোনখানে, ঐ যে ওয়ার্ডপ্রেসের সাথে এস্কিউলাইটের ডিফল্ট ইন্টিগ্রেশনের কোনো সিস্টেম নাই, হোয়াট এ হার্ট ব্রেকিং নিউজ। ডেভেলপাররা কি আর বসে থাকে? জাপানের কোজিমা তোশিয়াসু একটা চমৎকার ড্রপইন সলুশন তৈরী করেছিলেন যেখানে একটা ফাইল আপনার ওয়ার্ডপ্রেস ইন্স্টলেশনের মধ্যে রেখে দিয়ে একটু কনফিগারেশন করে দিলেই ওয়ার্ডপ্রেসের সাথে এস্কিউলাইট ব্যবহার করা যাবে। এরপরে এটার উপরে বেশ কিছু ইম্প্রুভমেন্ট করেছেন ইভান ম্যাটসন। তবে অনেকদিন ধরে এই রিপোজিটরিতে আপডেট দেয়া হয়নি, সো পিএইচপি এইটের সাথে কম্প্যাটিবল ছিল না এটা, পরে আমি সেটা অ্যাড করে দিয়েছি। 

অ্যাড করতে করতে আমার মনে হলো আমি চাইলেই তো এটাকে সবার জন্য আরো সহজ একটা সলুশন হিসেবে রিলিজ করে দিতে পারি, যেটা দিয়ে টার্মিনালে (লিনাক্স, উইন্ডোজ এবং ম্যাক) একটা কমান্ড দিলেই পুরো সেটআপটা এক নিমিষে রেডি হয়ে যাবে, যা যা কনফিগারেশন প্রয়োজন সেটা অটোমেটিকালি আমার স্ক্রিপ্ট থেকেই করে ফেলব, তাহলে মানুষের জন্য ঝামেলা আরো কমে যাবে তাই না? পাশাপাশি একটা চমৎকার সলুশন রেডি হয়ে যাবে কুইকলি একটা পোর্টেবল ওয়ার্ডপ্রেস সেটআপ তৈরি করার জন্য - কমান্ড দিবেন, কাজ শুরু করবেন :) 

আমি প্রথমে প্রভিশনিং এর জন্য শেলস্ক্রিপ্ট লিখেছিলাম, লিনাক্স আর ম্যাকের জন্য। সেটা উইন্ডোজে পোর্ট করতে গিয়ে দেখলাম অনেক ঝামেলা, লিনাক্স সাবসিস্টেম ইনস্টল্ড না থাকলে রান করা যাবে না। শেষ পর্যন্ত ভাবছিলাম পাওয়ারশেল স্ক্রিপ্ট লিখে দেয়ার জন্য, এমন সময়  অবি প্লাবন বললো যে এটাকে ফার ফাইল হিসেবে রিলিজ করে দিলেই তো হয় - আরো সহজ হবে সবার জন্য, আমিও দেখলাম আইডিয়াটা মন্দ না। 

ফার নিয়ে আমি আগে কাজ করি নাই, এখানে প্রজেক্ট লেখা একটু ডিফারেন্ট, বিল্ড করাও হ্যাপা - যাইহোক পরশুদিন সন্ধ্যা থেকে এটার উপরে পড়াশোনা শুরু করেছি, গতকাল সন্ধ্যায় লিনাক্স/ম্যাক/উইন্ডোজের জন্য ফার ফাইলটা তৈরি করে ফেলেছি :) আর হোস্ট কনফিগারেশন যাতে আপনার নিজের না করতে হয় সেজন্য wplocal.xyz একটা ডোমেইন কিনেছি এবং এটাতে ওয়াইল্ডকার্ড ডিএনএস ম্যাপিং করেছি যাতে আপনি *.wplocal.xyz এ পিং করলে সবসময় সেটা আপনার লোকালহোস্টে পয়েন্ট করে, মানে ping anything.wplocal.xyz কমান্ড দিলেই সেটা 127.0.0.1 কে পয়েন্ট করবে। 

কমান্ড লাইনের কাজটা করার জন্য সিম্ফোনি কনসোল কম্পোনেন্ট নিয়ে কাজ করতে হয়েছে, এটা নিয়েও কাজ করি নাই আগে। ফাইলসিস্টেমের ফাংশন গুলো নিয়ে কাজ করতে হয়েছে যেগুলো সাধারণত তেমন ব্যবহার করা হয় না ডেইলি প্রজেক্টে - মোট কথা সেই লেভেলের মজা পেয়েছি পুরো কাজটা করতে গিয়ে 

আজকে এটা সবার জন্য রিলিজ করে দিলাম এখানে https://github.com/hasinhayder/wpsqlite, ব্যবহার কিভাবে করতে হবে বা সোর্স কোড চেক করার জন্য এই রিপোজিটরিতে চলে যাবেন। আপনার অপারেটিং সিস্টেম যাই হোক না কেন, মেশিনে পিএইচপি, পিডিও এস্কিউলাইট এক্সটেনশন আর কার্ল এক্সটেনশন ইনস্টল করা থাকলেই কাজ করবে :) ইউজুয়ালি সবার মেশিনেই এক্সটেনশন গুলো বাই ডিফল্ট থাকেই, জাস্ট এনাবল করে নিতে হয় কারো কারো মেশিনে পিএইচপি আইএনআই (php.ini) ফাইল থেকে। 

ফার ফাইল টা গ্লোবাল পাথে রাখেন বা লোকাল পাথে  - এরপর কমান্ড দেন এটা  ’php wpsqlite.phar install’, ব্যাস আপনার পোর্টেবল ওয়ার্ডপ্রেস সেটআপ উইথ এস্কিউলাইট একদম রেডি। এখন পেনড্রাইভেও ওয়ার্ডপ্রেস ইনস্টলেশন পসিবল। ইনস্টল করবেন, পকেটে নিয়ে ঘুরে বেড়াবেন, যেখানে ইচ্ছা, যেই মেশিনে ইচ্ছা সেখানে বসে কাজ করবেন, পুরাই বিন্দাস লাইফ আর কি। 

<3





