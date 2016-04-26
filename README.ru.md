Yii2 Стартовое приложение
=========================

* [Требования](#Требования)
* [Установка yii2-app-start](#Установка-yii2-app-start)
* [Создание собственного приложения](#Создание-собственного-приложения)

Требования
----------

Минимальное требование к веб-серверу - поддержка PHP 5.5.

Для установки необходимых расширений PHP выполните в командной строке:

~~~
sudo apt-get install php5-mysql php5-sqlite php5-imagick php5-intl php5-memcache php5-curl
~~~

Установка yii2-app-start
------------------------

### 1. Склонируйте репозиторий проекта

~~~
git clone https://github.com/neogen-projects/yii2-app-start.git
~~~

### 2. Установите зависимоcти проекта

Если у вас не установлен [Composer](http://getcomposer.org/), то установите его следуя инструкции
с официального сайта [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

Выполните следующие команды в корневой папке проекта `yii2-app-start`:

~~~
composer global require fxp/composer-asset-plugin --no-plugins
composer install
composer run-script post-create-project-cmd
~~~

### 3. Создайте схему базы данных

Выполните в корневой папке проекта:
    
~~~
sudo mysql -u root < data/create_db.sql
php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
~~~

### 4. Настройте web-сервер Apache

Выполните в корневой папке проекта:

~~~
sudo ln -s `pwd` /var/www/yii2start
sudo a2enmod rewrite
sudo cp ./config/webserver/apache-site.conf /etc/apache2/sites-available/yii2start.conf
sudo a2ensite yii2start
sudo service apache2 restart
~~~

По адресу [http://localhost](http://localhost) теперь должна открываться стартовая страница приложения.


Создание собственного приложения
--------------------------------

Вы может создать свое веб-приложение `myapp` на основе проекта `yii2-app-start`.

### 1. Скопируйте файлы проекта

Вы можете скопировать файлы проекта `yii2-app-start` в `myapp` выполнив команды:

~~~
wget https://github.com/neogen-projects/yii2-app-start/archive/master.zip
unzip master.zip; rm master.zip
mv yii2-app-start-master myapp
~~~

### 2. Установите зависимоcти проекта

Если у вас не установлен [Composer](http://getcomposer.org/), то установите его следуя инструкции
с официального сайта [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

Выполните следующие команды в корневой папке проекта `myapp`:

~~~
composer global require fxp/composer-asset-plugin --no-plugins
composer install
composer run-script post-create-project-cmd
~~~

### 3. Измените название проекта

Отредактируйте файл `composer.json`, указав название и параметры вашего проекта `myapp`.
В файлах `config/web.php` и `config/console.php` замените значение параметра `id` на
актуальное название вашего проекта.

### 4. Создайте схему базы данных

Укажите в файле `data/create_db.sql` данные БД для вашего проекта:

```sql
CREATE DATABASE myapp CHARACTER SET utf8;
CREATE USER 'myapp'@'localhost' IDENTIFIED BY 'myapp_password';
GRANT ALL PRIVILEGES ON myapp.* TO 'myapp'@'localhost';
```

Укажите в файле `config/db.php` актуальные параметры для подключения к БД:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=myapp',
    'username' => 'myapp',
    'password' => 'myapp_password',
    'charset' => 'utf8',
];
```

Выполните в корневой папке проекта:
    
~~~
sudo mysql -u root < data/create_db.sql
php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
~~~

### 5. Настройте web-сервер Apache

Укажите в файле `config/webserver/apache-site.conf` актуальные данные для вашего проекта:

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

Выполните в корневой папке проекта:

~~~
sudo ln -s `pwd` /var/www/myapp
sudo a2enmod rewrite
sudo cp ./config/webserver/apache-site.conf /etc/apache2/sites-available/myapp.conf
sudo a2ensite myapp
sudo service apache2 restart
~~~

По адресу [http://localhost](http://localhost) теперь должна открываться стартовая страница вашего приложения.
