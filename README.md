# SPA Starter API

[![Build Status][ico-travis]][link-travis]
[![StyleCI][icon-styleci]][link-styleci]
[![Coverage Status][ico-code-climate]][link-code-climate]
[![Quality Score][ico-code-quality]][link-code-quality]

SPA Starter Pack API is written in Lumen 5.4, you can see a fully functional [demo here](https://spa-starter-api.herokuapp.com), you can also see the [![API documentation here]][link-docs].

## Features

- API written in [Lumen 5.4](https://github.com/laravel/lumen/tree/v5.4.0)
- Authentication using [JWT](https://github.com/tymondesigns/jwt-auth) (JSON Web Token)
- Development environment using [Ambientum](https://github.com/codecasts/ambientum) (Docker)

## Up and Running

- Clone this repository `$ git clone git@github.com:coderwebschool/spa-starter-api.git`
- Create the env file `$ cp .env.example .env`
- Generate a **random string with 32 characters** for the **APP_KEY** variable on your **.env** file.

**Using PHP built-in server**

- Create the database file `$ touch database/database.sqlite`
- Install composer dependencies `$ composer install`
- Generate a JWT secret key `$ php artisan jwt:secret`
- Migrate the database and run the seeders `$ php artisan migrate --seed`
- Start the server `$ php -S localhost:8000 -t public`

**Using Docker**

- Start docker `$ docker-compose up -d`
- Uncomment the database variables at the **.env** file.
- Install composer dependencies `$ docker-compose run app composer install`
- Generate a JWT secret key `$ docker-compose run app php artisan jwt:secret`
- Migrate the database and run the seeders `$ docker-compose run app php artisan migrate --seed`

Visit [http://localhost:8000](http://localhost:8000)

## Resources

- [Sign In](./docs/SignIn.md)
- [Sign Up](./docs/SignUp.md)
- [Show Me](./docs/ShowMe.md)

**Authors**

- [Show All](./docs/Authors/ShowAll.md)
- [Create](./docs/Authors/Create.md)
- [Show](./docs/Authors/Show.md)
- [Update](./docs/Authors/Update.md)
- [Delete](./docs/Authors/Delete.md)

**Books**

- [Show All](./docs/Books/ShowAll.md)
- [Create](./docs/Books/Create.md)
- [Show](./docs/Books/Show.md)
- [Update](./docs/Books/Update.md)
- [Delete](./docs/Books/Delete.md)

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
[link-docs] ./docs/README.md
