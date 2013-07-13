# CivicScore Rankings


## Requirements

1. PHP 5.2 or greater
2. MySQL


## Codebase
This is a basic PHP app using the [CodeIgniter framework](http://www.codeigniter.com/) with [Phil Sturgeon's Rest Server](https://github.com/philsturgeon/codeigniter-restserver) for the API and [jQuery mobile](http://jquerymobile.com/) for the mobile app. 

The functionality of the codebase is broken down into three parts

1. **application/controllers/scraper.php** - A parser which pulls in data from Yelp or other sources. This should only need to be run periodically. A fully populated sql database file has also been included with this repo at **sql/civicscoredata.sql**

2. **application/controllers/api.php** - A full featured hypermedia REST API. This is documented with an html page which can be viewed at `/api` in your browser or in the source at **application/views/api_docs.php**

3. **application/controllers/answers.php** and **application/controllers/topics.php** are used to make API calls (locally to the app itself) for use with the mobile app. 


## Installation and Configuration

1. Copy **application/config/config.php.sample.php** to **application/config/config.php** and edit with the appropriate values. In most cases, you will only need to edit `website_root` but if you plan to use the scraper to parse the APIs, you'll need to set appropriate values for the APIs. 
2. Copy **application/config/database.php.sample.php** to **application/config/database.php** and edit with the appropriate values for your MySQL connection. You'll also want to import the SQL database file included with the repo, eg `mysql -u root -p civicscoredata < civicscoredata.sql`
2. Copy **sample.htaccess** to **.htaccess**. In most cases you won't need to edit this file, but in some cases .htaccess configurations need to be tweaked for different environments. 


## Deploy

As a PHP app, there's nothing special needed for deployment. The files can be placed in an Apache virtual host directory just as any other PHP app would be. Other than setting up the right values in the config.php and database.php files there shouldn't be any other setup or deployment needed. You will need to ensure that Apache is set to accept the .htaccess file (eg 'AllowOverride All') and in some cases, you may need to make adjustments to your .htaccess, but in most cases the standard .htaccess file from CodeIgniter packaged here should work just fine. 
