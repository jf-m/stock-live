<p align="center">

[![PHPUnit](https://github.com/jf-m/stock-live/actions/workflows/tests.yml/badge.svg)](https://github.com/jf-m/stock-live/actions/workflows/tests.yml)
[![Static Analysis](https://github.com/jf-m/stock-live/actions/workflows/static-analysis.yml/badge.svg)](https://github.com/jf-m/stock-live/actions/workflows/static-analysis.yml)

</p>

<img width="1284" alt="image" src="https://github.com/jf-m/stock-live/assets/9339799/95d2dcf3-709a-4a9d-8635-acecfe8baec7">

## stock-live

Demo project that consumes Alpha Vantage API, using Laravel's Job, Cache, Eloquent and PHPUnit. It provides an endpoint to get the latest price of a stock and a simple dashboard that displays a Percentage Change of 10 Stocks.

This project uses Laravel 11, Vue.js 3, TailwindCSS, Vite.

# Installation

## Install the dependencies and build

Execute the following to install the dependencies and build the front using Docker and Laravel Sail:
```shell
# Install the PHP dependencies
docker run -it --rm -v `pwd`:/app composer install
# Start laravel sail (Docker)
./vendor/bin/sail up -d
# Install JS dependencies
./vendor/bin/sail npm install
# Build the front
./vendor/bin/sail npm run build
# Copy the environment file
cp .env.example .env
```

## Configuration file

Update the file `.env`'s value for `ALPHA_VANTAGE_API_KEY` with your Alpha Vantage API key. 

## Start the local environment

Execute the two following commands in separate terminals:
```shell
# Start laravel sail (Docker)
./vendor/bin/sail up -d
```

The front should be available on `http://localhost`

## Seed the database

Execute the following commands to seed the database with 10 stocks and the latest market value for each stock:

```shell
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan market:fetch
```

# Endpoints

| Endpoint               | Description                                                              |
|------------------------|--------------------------------------------------------------------------|
| `/api/stock/{symbol}/price/latest` | Return the latest market price data for a stock (eg. IBM, AAPL, MSFT...) |


# Contributing

Execute code analysis, phpunit and Laravel pint using the following commands:
```shell
# Start phpstan analysis
./vendor/bin/sail php ./vendor/bin/phpstan --memory-limit=2G

# Start phpunit tests case
./vendor/bin/sail test

# Start Laravel Pint
./vendor/bin/sail php ./vendor/bin/pint 
```
