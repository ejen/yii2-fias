# yii2-fias
Инструменты для работы с ФИАС в Yii2

# Создание таблиц в базе данных

```
./yii migrate --migrationPath=@vendor/ejen/yii2-fias/console/migrations
```

# Настройка консольного приложения

Для выполнения консольных комманд необходимо добавить следующую настройку в конфиг консольного приложения:

```
    ...
    'controllerMap' => [
        'fias' => 'ejen\fias\console\controllers\FiasController',
    ],
    ...
```

# Консольные команды

## Импорт dbf файла в базу данных
```
./yii fias/import-dbf /path/to/FILENAME.DBF
```
