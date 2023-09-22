# Todo App

This App allows users manage and organise their day-to-day activities for better productivity.
This is the backend project of this app.

## Installation

### Requirements

- [PHP 8.1](https://www.php.net/downloads.php) or later
- [Composer](https://getcomposer.org/)
- Any DB Admin Software of your choice like [MySQL Workbench](https://www.mysql.com/products/workbench/), [TablePlus](https://tableplus.com/download), [phpMyAdmin](https://www.phpmyadmin.net/), etc
- [Docker](https://www.docker.com/products/docker-desktop/) (Optional)
- Your prefered IDE

### Install with Laravel Sail

To use Laravel Sail, you will need to have Docker installed on your local machine.

1. Clone the project from the repository and then cd into the root directory

```sh
git clone https://github.com/Oluyosola/todo-app.git
cd todo-app
```

2. Install dependencies

```sh
composer install
```

3. Create your `.env` file using your `.env.example` as a template.

4. Run Laravel Sail. You can use the -d flag to run it in the background.

```sh
sail up -d
```

5. Set up the database on your DB Admin software using the credentials in your `.env` file.

6. Generate application key

```sh
sail artisan key:generate
```

7. Migrate the migration files.

```sh
sail artisan migrate
```


8. Open the project on your browser.


```sh
http://127.0.0.1
```

### Note

With Laravel Sail, you have to run you artisan commands like this:

```sh
sail artisan [command]
```

For more info on Laravel Sail, you can check  out the official documentation on the [Laravel Docs website](https://laravel.com/docs)
