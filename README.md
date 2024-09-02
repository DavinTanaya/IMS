Inventory Management System

Step to run this project:
```
- Open XAMPP
- Open Apache -> config -> php.ini
- Search extension=gd
- Remove ;
- Save
```
- `git clone https://github.com/DavinTanaya/IMS`
- `cp .env.example .env`
- `composer i`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan key:generate`
- `php artisan storage:link`
- `php artisan serve`
- Open another terminal
- `npm i`
- `npm run dev`

```
Seeder:
User: davin.tanaya@gmail.com
Password: secret

Admin: admin@gmail.com
Password: secret
```
