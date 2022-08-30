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

- Create your CMS/.env file by editing provided CMS/.env.example with $ `cp .env.example .env`

- Install vendor files with composer: $ `composer install`

- Generate key for .env using this command: $ `php artisan key:generate`

- Create `database` in your localhost name - `cms`

- Config database in your `.env` file `DB_DATABASE=cms`

- Install database schema & default data: $ `php artisan migrate --seed`

- Run this command for serve your project in localhost: $ `php artisan serve`

- The project can be accesible by going to `127.0.0.1:8000`
