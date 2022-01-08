# Author

Risky Kurniawan

# LaravelPTKledo
 
Cara Instalasi Aplikasi

Buka direktori "LaravelPTKledo\laravel" menggunakan command prompt

ketikan perintah "composer install" pada command prompt dan tunggu proses hingga selesai

Copy file ".env.example" pada direktori "LaravelPTKledo\laravel" dan simpan dengan nama ".env"

ketikan perintah "php artisan key:generate" pada command prompt dan tunggu proses hingga selesai

buka file ".env" dan lakukan konfigurasi pada APP_URL=http://localhost

ketikan perintah "php artisan optimize" pada command prompt dan tunggu proses hingga selesai

Lakukan konfigurasi database aplikasi (pada pembuatan menggunakan MariaDB)

ketikan perintah "php artisan migrate" pada command prompt dan tunggu proses hingga selesai

Untuk menjalankan ketikan "php artisan serve" dan copy link yang tersedia kedalam browser

Selesai


# testing
Buka direktori "LaravelPTKledo\laravel" menggunakan git bash

ketikan perintah "./vendor/bin/phpunit ./tests/Feature/TestingCode.php" tanpa kutip

# testing - 2
Gunakan aplikasi postman dengan mengimport data pada folder postman