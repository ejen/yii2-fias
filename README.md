Это клон репозитория от ejen. Создал его по причине того, что изначальный код давно не обновлялся. 

# yii2-fias
Инструменты для работы с ФИАС в Yii2

# Установка

Предпочтительный способ установки расширения - через [composer](http://getcomposer.org/download/).

Выполните

```
php composer.phar require --prefer-dist yii2/yii2-fias
```

или добавьте

```
"ejen/yii2-fias": "@dev"
```

в соответствующую секцию файла `composer.json`.

# Создание таблиц в базе данных

```
./yii migrate --migrationPath=@vendor/ejen/yii2-fias/console/migrations
```

# Настройка консольного приложения

Для выполнения консольных комманд необходимо добавить следующую настройку в конфиг консольного приложения:

```php
    ...
    'controllerMap' => [
        'fias' => [
            'class' => 'ejen\fias\console\controllers\FiasController',
        ]
    ],
    ...
```

# Консольные команды

## Импорт dbf файла в базу данных
```
./yii fias/import-dbf /path/to/FILENAME.DBF --region=66
```

Опция region является не обязательной и позволяет импортировать записи относящиеся только к конкретному региону(в случае импорта ADDROBJ.DBF)

