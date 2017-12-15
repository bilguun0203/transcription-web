# Transcription Web

### Суулгах

#### Шаардалага

`PHP 7.1`

`MySQL`

#### Laravel болон бусад шаардлагатай package суулгах

`composer install` тушаалаар шаардлагатай package-уудыг суулгах

#### .env файл тохируулах

1. `.env.example` файлыг `.env` болгох
2. `php artisan key:generate` тушаалыг өгч `APP_KEY` үүсгэх
3. Бусад шаардлагатай тохиргоог доорх хэсгээс харна уу

`APP_NAME="Transcription Web"`

`APP_ENV=local`

`APP_DEBUG=true`

`APP_LOG_LEVEL=debug`

`APP_URL=http://transcription.dev` http://transcription.web-ийн оронд өөрийн веб рүү хандах хаягаа бичнэ

--

`DB_CONNECTION=mysql` - MySQL

`DB_HOST=127.0.0.1`

`DB_PORT=3306`

`DB_DATABASE=transcription-web` - Өгөгдлийн сангийн нэр

`DB_USERNAME=root` - Өгөгдлийн сангийн хэрэглэгчийн нэр

`DB_PASSWORD=` - Өгөгдлийн сангийн нууц үг
