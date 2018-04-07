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
4. Өгөгдлийн сангийн мэдээллийг оруулсны дараа `php artisan migrate` тушаалаар хүснэгтүүдийг үүсгэнэ. 

`APP_NAME="Transcription Web"`

`APP_ENV=local`

`APP_DEBUG=true`

`APP_LOG_LEVEL=debug`

`APP_URL=http://transcription.dev` http://transcription.dev-ийн оронд өөрийн веб рүү хандах хаягаа бичнэ

--

`DB_CONNECTION=mysql` - MySQL

`DB_HOST=127.0.0.1`

`DB_PORT=3306`

`DB_DATABASE=transcription-web` - Өгөгдлийн сангийн нэр

`DB_USERNAME=root` - Өгөгдлийн сангийн хэрэглэгчийн нэр

`DB_PASSWORD=` - Өгөгдлийн сангийн нууц үг

#### .env файл дахь бусад тохиргоонууд

`TIME=3600` - Хэрэглэгч даалгавар авснаас ямар хугацааны дараа өөр хүн тухайн даалгаварыг авах боломжтой болохийг тохируулах (секунд)

`VALIDATION_COUNT=3` - Нэг бичвэрийг шалгах тоо

`TRANSCRIPTION_RULE="/(^(<p>#D)?[А-Яа-яЁёӨөҮү \.\*!\?,\.\(\)~\$%#<>GN-p\/]{1,}$)/u"` - Бичвэрийг дүрмийн дагуу байгаа эсэхийг шалгах regular expression

`SCORE_TRANSCRIPTION_ADD=0.5` - Бичвэр оруулахад авах оноо

`ENABLE_TASK_TRANSCRIBE=1` - Бичвэрт буулгах даалгавар идэвхтэй эсэх (0 - идэвхгүй, 1 - идэвхтэй)

`ENABLE_TASK_VALIDATE=1` - Шалгах даалгавар идэвхтэй эсэх (0 - идэвхгүй, 1 - идэвхтэй)

`ENABLE_TASK_EDIT=1` - Засах даалгавар идэвхтэй эсэх (0 - идэвхгүй, 1 - идэвхтэй)

`SCORE_PER_ACCEPTED_TRANSCRIPTION=0.5` - Оруулсан бичвэр нь зөв гэсэн санал авах тутам нэмэгдэх оноо

`SCORE_PER_DECLINED_TRANSCRIPTION=-0.5` - Оруулсан бичвэр нь буруу гэсэн санал авах тутам нэмэгдэх (сөрөг тэмдэгтэй бол хасагдах) оноо

`SCORE_VALIDATE=0.2` - Бичвэр шалгах даалгавар гүйцэтгэхэд өгөх оноо

`SCORE_EDIT_TRANSCRIPTION=0.2` - Бичвэр засах даалгавар гүйцэтгэхэд өгөх оноо

#### Directory Permission

`/public/audio_files` - Бичих эрх шаардлагатай

`/storage` - Бичих эрх шаардлагатай
