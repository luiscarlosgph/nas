CloudNAS
========

Web application based on Django to operate a NAS.

Install
=======

1. Install Apache server.
2. Create the user and group 'nas'.
3. Clone this repository to /var/www.
4. Add this lines to your Apache config file (in Debian: /etc/apache2/sites-enabled/000-default):

		<VirtualHost *:80>
			ServerAdmin webmaster@localhost

			WSGIDaemonProcess nas python-path=/var/www:/var/www/env/lib/python2.7/site-packages
			WSGIProcessGroup nas
			WSGIScriptAlias / /var/www/nas/wsgi.py

			DocumentRoot /var/www

5. Enjoy!
