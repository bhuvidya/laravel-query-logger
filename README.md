# Laravel Query Logger

[![License](https://poser.pugx.org/bhuvidya/laravel-query-logger/license?format=flat-square)](https://packagist.org/packages/bhuvidya/laravel-query-logger)
[![Total Downloads](https://poser.pugx.org/bhuvidya/laravel-query-logger/downloads?format=flat-square)](https://packagist.org/packages/bhuvidya/laravel-query-logger)
[![Latest Stable Version](https://poser.pugx.org/bhuvidya/laravel-query-logger/v/stable?format=flat-square)](https://packagist.org/packages/bhuvidya/laravel-query-logger)
[![Latest Unstable Version](https://poser.pugx.org/bhuvidya/laravel-query-logger/v/unstable?format=flat-square)](https://packagist.org/packages/bhuvidya/laravel-query-logger)


**Note I have now switched the semver versioning for my Laravel packages to "match" the latest supported Laravel version.**

Laravel Query Logger is a package to enable easy and flexible logging of all or a select range of database queries. It supports standard logging, and well as dump-server.

Big kudos to github user `overtrue`, on whose work this package is based (https://github.com/overtrue/laravel-query-logger). I ended up doing so many changes that I thought it best to start my own package.

## Installation

Add `bhuvidya/laravel-query-logger` to your app:

    $ composer require "bhuvidya/laravel-query-logger"


## Configuration

You can do just about any configuration you need via your `.env` file. The env variables used are:

```
QUERY_LOGGER_ON
QUERY_LOGGER_ENV
QUERY_LOGGER_PARAM
QUERY_LOGGER_ALL
QUERY_LOGGER_MIN_TIME
QUERY_LOGGER_EMIT_LOG
QUERY_LOGGER_EMIT_LEVEL
QUERY_LOGGER_EMIT_CHANNEL
QUERY_LOGGER_EMIT_STACK
QUERY_LOGGER_EMIT_PREFIX
QUERY_LOGGER_EMIT_DUMP_SERVER
QUERY_LOGGER_INSTANCE
QUERY_LOGGER_FACADE
```

If for some reason you prefer to manage your own configuration file, run the following command:

```shell
$ php artisan vendor:publish --provider='Bhuvidya\Countries\CountriesServiceProvider' --tag=config
```

The config file can then be found at `config/query_logger.php`.


## Usage

TODO


## License

MIT

