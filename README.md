Yii2 Start Application
==========

1. Установка необходимых расширений PHP

```
    sudo apt-get install php5-mysql php5-sqlite php5-imagick php5-intl php5-memcache php5-curl
```

2. Установка зависимостей проекта

    Выполните в корневой папке проекта:

```
    composer install
    composer run-script post-create-project-cmd
```

3. Настройка базы данных

    Выполните в корневой папке проекта:
    
```
    mysql -u root -p < data/create_db.sql
   // php yii migrate
```

4. Настройка web-сервера

    Выполните в корневой папке проекта:

```
    sudo ln -s `pwd` /var/www/yii2start
    ls -l /var/www/yii2start
        lrwxrwxrwx 1 root root 35 июля  23 23:54 /var/www/yii2start -> </full/path/to/yii2start>

    sudo a2enmod rewrite
    sudo cp ./config/webserver/yii2start.conf /etc/apache2/sites-available/
    sudo a2ensite yii2start
    sudo service apache2 restart
```

    По адресу http://localhost:81 должна открываться стартовая страница приложения.
    