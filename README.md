# TheSwimSchool
A class management and payment processing system for a small local swim school. This application uses Laravel for the framwework, Vuejs for reacativity, MySQL for its database, and Uikit for the theme. 

# Installation

1. Composer install
```bash
composer install
```

2. Add Nova Auth

Copy auth.json file to the root of the project.

3. Run post install scripts

```bash
composer run post-root-package-install
composer run post-create-project-cmd
```

4. Install Node Modules

```bash
nvm use
npm install
```

5. Build the js and css

```bash
npm run production
```

6. Start the server

```bash
php artisan serve
```

## Testing

Create an .env.testing file and update the database connection to use the testing database. 

To run all the tests, use the following command:

```bash
php artisan test
```

To filter down to a specific test, use the following command:

```bash
php artisan test --filter=InstructorCalendarTest
```


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
