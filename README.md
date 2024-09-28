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

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
