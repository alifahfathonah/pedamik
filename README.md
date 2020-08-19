# Pedamik
Pengelola Data Akademik

## Fitur-Fitur
1. Pengelolaan Data Fakultas
2. Pengelolaan Data Jurusan
3. Pengelolaan Data Kelas
4. Pengelolaan Data Mata Kuliah
5. Pengelolaan Data Mahasiswa
6. Pengelolaan Data Dosen
7. Pengelolaan Data Kelas Dosen

### Install  Dependency
```bash
$ composer install
$ npm install
```

### Configure Database Connection
Open file ``configs/database.php``
```php
return [
    'driver'    => 'mysql',
    'host'      => 'yourdbname',
    'database'  => '10118068_Akademik',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
];
```
and change it with your database information

## Deployment
Open file ``bootstrap/app.php`` and find this line:
```php
$app->addErrorMiddleware(true, true, true);
```
change the first argument to ``false`` and save it.

### Install Dependency
```bash
composer install --optimize-autoloader --no-dev
```