# BGS-WEB

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

BGS-WEB is the core web application for the BGS MEDS marketplace at [www.bgsmeds.com](www.bgsmeds.com). 

---

## Requirements

For development, you will only need PHP 7+ and a php global package manager, composer, installed in your environment.

## Install

    $ git clone https://github.com/KevinMarete/bgs-web
    $ cd bgs-web
    $ composer install

## Configure app

Rename `.env.example` to `.env` then edit it with your custom settings. You will need:

- API Configuration
- Payment Configuration
- Database Configuration
- Email Configuration

## Resources

- [Passport Setup](https://stackoverflow.com/questions/39414956/laravel-passport-key-path-oauth-public-key-does-not-exist-or-is-not-readable)

## Running the project

    $ php artisan serve
