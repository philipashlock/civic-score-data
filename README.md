# USA.gov FAQs API & Mobile App

This app includes an importer/parser for the XML feed of FAQs from USA.gov ([answers.usa.gov](http://answers.usa.gov)) as well as a RESTful API interface and a mobile HTML5 UI based on that API. 

A working demo of this codebase can be seen at [http://usa-faq.civicagency.org](http://usa-faq.civicagency.org) and the API documentation can be seen at [http://usa-faq.civicagency.org/api](http://usa-faq.civicagency.org/api)

## Requirements

1. PHP 5.2 or greater
2. MySQL


## Codebase
This is a basic PHP app using the [CodeIgniter framework](http://www.codeigniter.com/) with [Phil Sturgeon's Rest Server](https://github.com/philsturgeon/codeigniter-restserver) for the API and [jQuery mobile](http://jquerymobile.com/) for the mobile app. 

The functionality of the codebase is broken down into three parts

1. **application/controllers/scraper.php** - A parser which pulls in the XML feed from USA.gov and adds it to a MySQL table. The feed is filtered and cleaned during this process and optionally augmented with extra tagging and metadata using the free OpenCalais service. This should only need to be run periodically. A fully populated sql database file has also been included with this repo at **sql/inquiry_usagov.sql**

2. **application/controllers/api.php** - A full featured hypermedia REST API. This is documented with an html page which can be viewed at `/api` in your browser or in the source at **application/views/api_docs.php**

3. **application/controllers/answers.php** and **application/controllers/topics.php** are used to make API calls (locally to the app itself) for use with the mobile app. 


## Installation and Configuration

1. Copy **application/config/config.php.sample.php** to **application/config/config.php** and edit with the appropriate values. In most cases, you will only need to edit `website_root` but if you plan to use the scraper to parse the xml feed, you'll need to set your `xml_file_path` and make sure that Apache and PHP have write permissions for that directory. 
2. Copy **application/config/database.php.sample.php** to **application/config/database.php** and edit with the appropriate values for your MySQL connection. You'll also want to import the SQL database file included with the repo, eg `mysql -u root -p usa_faqs < inquiry_usagov.sql`
2. Copy **sample.htaccess** to **.htaccess**. In most cases you won't need to edit this file, but in some cases .htaccess configurations need to be tweaked for different environments. 


## Deploy

As a PHP app, there's nothing special needed for deployment. The files can be placed in an Apache virtual host directory just as any other PHP app would be. Other than setting up the right values in the config.php and database.php files there shouldn't be any other setup or deployment needed. You will need to ensure that Apache is set to accept the .htaccess file (eg 'AllowOverride All') and in some cases, you may need to make adjustments to your .htaccess, but in most cases the standard .htaccess file from CodeIgniter packaged here should work just fine. 
