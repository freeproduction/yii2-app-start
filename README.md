Yii2 Start Application
======================

[Руководство на русском языке](README.ru.md)

* [Requirements](#requirements)
* [Yii2-app-start installation](#yii2-app-start-installation)
* [Create custom application](#create-custom-application)

Requirements
------------

The minimum requirement by this project template that your Web server supports PHP 5.5.

To install required PHP-packages execute following commands:

~~~
sudo apt-get install php-mysql php-imagick php-intl php-memcache php-curl php-cli php-mbstring
~~~

Yii2-app-start installation
---------------------------

### 1. Clone project repository

~~~
git clone https://github.com/neogen-projects/yii2-app-start.git
~~~

### 2. Install dependencies

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

Execute following commands in the root directory of the `yii2-app-start` project:

~~~
composer global require fxp/composer-asset-plugin --no-plugins
composer install
composer run-script post-create-project-cmd
~~~

### 3. Create database schema

Execute following commands in the root directory of the project:
    
~~~
sudo mysql -u root < data/create_db.sql
php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
php yii migrate --migrationPath=@yii/rbac/migrations
~~~

### 4. Configure Apache Web server

Execute following commands in the root directory of the project:

~~~
sudo ln -s `pwd` /var/www/yii2start
sudo a2enmod rewrite
sudo cp ./config/webserver/apache-site.conf /etc/apache2/sites-available/yii2start.conf
sudo a2ensite yii2start
sudo service apache2 restart
~~~

You can then access the application through the URL [http://localhost](http://localhost)


Create custom application
-------------------------

You can create custom `myapp` web application based on the `yii2-app-start` project.

### 1. Copy project files

You can copy `yii2-app-start` project files to `myapp` using the following commands:

~~~
wget https://github.com/neogen-projects/yii2-app-start/archive/master.zip
unzip master.zip; rm master.zip
mv yii2-app-start-master myapp
~~~

### 2. Install dependencies

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

Execute following commands in the root directory of the `myapp` project:

~~~
composer global require fxp/composer-asset-plugin --no-plugins
composer install
composer run-script post-create-project-cmd
~~~

### 3. Change project name

Отредактируйте файл `composer.json`, указав название и параметры вашего проекта `myapp`.
В файлах `config/web.php` и `config/console.php` замените значение параметра `id` на
актуальное название вашего проекта.

### 4. Create database schema

Edit the file `data/create_db.sql` with real data of the `myapp` application:

```sql
CREATE DATABASE myapp CHARACTER SET utf8;
CREATE USER 'myapp'@'localhost' IDENTIFIED BY 'myapp_password';
GRANT ALL PRIVILEGES ON myapp.* TO 'myapp'@'localhost';
```

Edit the file `config/db.php` with real parameters of the `myapp` DB connection:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=myapp',
    'username' => 'myapp',
    'password' => 'myapp_password',
    'charset' => 'utf8',
];
```

Execute following commands in the root directory of the project:
    
~~~
sudo mysql -u root < data/create_db.sql
php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
~~~

### 5. Configure Apache Web server

Edit the file `config/webserver/apache-site.conf` with real data of the `myapp` application:

```
<VirtualHost *:80>
    DocumentRoot "/var/www/myapp/web"

    <Directory "/var/www/myapp/web">
        # use mod_rewrite for pretty URL support
        RewriteEngine on
        # If a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # Otherwise forward the request to index.php
        RewriteRule . index.php

        Options +Indexes +FollowSymLinks +MultiViews
        AllowOverride All
        Order allow,deny
        allow from all
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/myapp-error.log
    CustomLog ${APACHE_LOG_DIR}/myapp-access.log combined
</VirtualHost>
```

Execute following commands in the root directory of the project:

~~~
sudo ln -s `pwd` /var/www/myapp
sudo a2enmod rewrite
sudo cp ./config/webserver/apache-site.conf /etc/apache2/sites-available/myapp.conf
sudo a2ensite myapp
sudo service apache2 restart
~~~

You can then access the application through the URL [http://localhost](http://localhost)

Testing
-------

Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework](http://codeception.com/).
By default there are 3 test suites:

- `unit`
- `functional`
- `acceptance`

Tests can be executed by running

```
composer exec codecept run
``` 

The command above will execute unit and functional tests. Unit tests are testing the system components, while functional
tests are for testing user interaction. Acceptance tests are disabled by default as they require additional setup since
they perform testing in real browser. 


### Running  acceptance tests

To execute acceptance tests do the following:  

1. Rename `tests/acceptance.suite.yml.example` to `tests/acceptance.suite.yml` to enable suite configuration

2. Replace `codeception/base` package in `composer.json` with `codeception/codeception` to install full featured
   version of Codeception

3. Update dependencies with Composer 

    ```
    composer update  
    ```

4. Download [Selenium Server](http://www.seleniumhq.org/download/) and launch it:

    ```
    java -jar ~/selenium-server-standalone-x.xx.x.jar
    ``` 

5. (Optional) Create `yii2start_tests` database and update it by applying migrations if you have them.

   ```
   tests/bin/yii migrate
   ```

   The database configuration can be found at `config/test_db.php`.


6. Start web server:

    ```
    tests/bin/yii serve
    ```

7. Now you can run all available tests

   ```
   # run all available tests
   composer exec codecept run

   # run acceptance tests
   composer exec codecept run acceptance

   # run only unit and functional tests
   composer exec codecept run unit,functional
   ```

### Code coverage support

By default, code coverage is disabled in `codeception.yml` configuration file, you should uncomment needed rows to be able
to collect code coverage. You can run your tests and collect coverage with the following command:

```
#collect coverage for all tests
composer exec codecept run -- --coverage-html --coverage-xml

#collect coverage only for unit tests
composer exec codecept run unit -- --coverage-html --coverage-xml

#collect coverage for unit and functional tests
composer exec codecept run functional,unit -- --coverage-html --coverage-xml
```

You can see code coverage output under the `tests/_output` directory.
