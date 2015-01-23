CCloak
===========
CCloak is a simple wrapper-class for link cloaking within the Anax framework (https://github.com/mosbth/Anax-MVC.git)

How to use
==========

1. Download
-----------

The easiest way is to install using composer. Add to your composer.json:
```javascript
"require": {
	"alcr33k/ccloak": "dev-master",
	"mos/cform": "2.*@dev",
	"mos/cdatabase": "dev-master"
}
```
Then run composer update.

2. MySql
---------------------

The package is using MySql so make sure you have MySql setup in your Anax framework. If you have, go the next step, if not follow these steps:

Open the folder config in the package and you will find the file "database_mysql.php", open the file and you will see that the first 3 fields (dsn, username, password) are empty. Fill those with your dsn, your database username and your database password. 

Now save the file and move it to the anax config folder (app/config). You have now MySql done.

3. Setup
---------------------

Have you a file called "database_mysql.php" with your mysql credentials in you Anax config, if you answered yes keep on reading.

The first thing you need to do when you have installed the package is to move the file "redirect.php" located in the folder "move-to-webroot" to your actual webroot folder. 

Move the cloak folder to app/src and you are now good to go!

Now visit webroot/redirect.php and start creating some redirects. The package will automatically setup the databses needed. 


4. How to use
------------------

The url to visit one of the redirects you created in redirects.php is as follows:

**redirect.php?url=linkName** (change linkname to whatever you named the redirect)


Enjoy!
.
..:  Copyright (c) 2014 - 2015 Alexander Björkenhall, alex.alle@hotmail.com