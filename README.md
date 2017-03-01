# SPA Starter API

[![Build Status][ico-travis]][link-travis]
[![StyleCI][icon-styleci]][link-styleci]
[![Coverage Status][ico-code-climate]][link-code-climate]
[![Quality Score][ico-code-quality]][link-code-quality]

SPA Starter Pack API written in Lumen 5.4

## Up and Running

- Clone the project `$ git clone git@github.com:coderwebschool/spa-starter-api.git`
- Create the env file `$ cp .env.example .env`
- Create the database file `$ touch database/database.sqlite`
- Install composer dependencies `$ composer install`
- Generate a **random string with 32 characters** for the **APP_KEY** variable on your **.env** file.
- Generate a JWT secret key `$ php artisan jwt:generate`
- Migrate the database and run the seeders `$ php artisan migrate --seed`
- Start the server `$ php -S localhost:8000 -t public`
- Visit **http://localhost:8000**

> See the full documentation of the [API endpoints here][link-endpoits-doc].

## Contributing

- Fork it!
- Create your feature branch from master: `$ git checkout -b feature/my-new-feature`
- Write your code, comment your code, test your code
- Commit your changes `$ git commit -am 'Add some feature'`
- Push to the branch `$ git push origin feature/my-new-feature`
- Submit a pull request to master branch

## Testing

``` bash
$ composer test
```

## Credits

- [Lucas Pires][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-travis]: https://img.shields.io/travis/coderwebschool/spa-starter-api/master.svg?style=flat-square
[icon-styleci]: https://styleci.io/repos/79132679/shield?branch=master
[ico-code-climate]: https://img.shields.io/codeclimate/coverage/github/coderwebschool/spa-starter-api.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/codeclimate/github/coderwebschool/spa-starter-api.svg?style=flat-square

[link-travis]: https://travis-ci.org/coderwebschool/spa-starter-api
[link-styleci]: https://styleci.io/repos/79132679
[link-code-climate]: https://codeclimate.com/github/coderwebschool/spa-starter-api/coverage
[link-code-quality]: https://codeclimate.com/github/coderwebschool/spa-starter-api/code
[link-author]: https://github.com/flyingluscas
[link-contributors]: ../../contributors
[link-endpoits-doc]: ENDPOINTS.md
