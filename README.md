FileSharer
==========

Upload files and get an URL to share! This tool was created to save your and your contact's mailbox from huge attachments.

This project is a work in progress, but already usable.

Please follow these steps to install FileSharer on your own machine.

Prerequisites
-------------

* PHP 5.3.x or newer (tested with PHP 5.4)
* A webserver capable executing PHP (tested with Apache HTTP Daemon)
* Composer Dependency Manager (see https://getcomposer.org)
* (Optional) A recent version of PHPUnit, if you want to run the unit tests (see http://phpunit.de/manual/current/en/installation.html)

Installation
------------

Perform the installation steps in this order:

  1. Clone this project if you haven't already done so:

		git clone https://github.com/sideshow-systems/FileSharer.git

  2. Change into the project directory:

		cd FileSharer

  3. Prepare dependencies:

		composer install

  4. If you want to perform the included unit tests you may now perform them:

		phpunit

  5. Now ensure that the project root directory is accessible from your webserver.

  6. The following directories must be writable from the webserver:

	* data
	* misc/css
	* misc/js/vendor

  7. If you use Apache HTTP Daemon as webserver, the data directory already contains a .htaccess file to prevent direct access to data files (given that you allow .htaccess rules)


Usage
-----

Using FileSharer consists of two use cases: Upload data and download data.

To upload a file, point your browser to access http://myhost/path/to/FileSharer/uploadr/. If the installation is correct, you can now see a screen with a large drop area where you can drop files you drag from outside, e.g. a file manager window.

After uploading a file you get an url you can copy and paste it in a document (like an email to the file recipient). The recipient can download the file by opening the given url.


