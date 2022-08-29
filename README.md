DollaBills is an online platform where people can pay for content (photos and videos, live streams) via a monthly membership. Content is mainly created by YouTubers, fitness trainers, models, content creators, public figures, in order to monetise their profession.

## Installation
**Requirements**
- PHP 7.4 +
- Laravel
- Javascript / Vuejs  
- MySQL
- NPM
- Xampp
- Git
- Composer
- IDE

## Install Step
- Clone this repository: $ `git clone https://github.com/mahbubhabib/CMS.git`

- cd to project directory: $ `cd CMS`

- Create your onlynudez/.env file by editing provided onlynudez/.env.example with $ `cp .env.example .env`

- Install vendor files with composer: $ `composer install`

- Generate key for .env using this command: $ `php artisan key:generate`

- Create `database` in your localhost name - `CMS`

- Config database in your `.env` file `DB_DATABASE=CMS`

- Install database schema & default data: $ `php artisan migrate`

- Run this command for serve your project in localhost: $ `php artisan serve`

- The project can be accesible by going to `127.0.0.1:8000`
