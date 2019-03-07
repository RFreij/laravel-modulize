# Currently in development

# Laravel Modulize API
[![Build Status](https://travis-ci.com/RFreij/laravel-modulize-api.svg?branch=master)](https://travis-ci.com/RFreij/laravel-modulize-api)
[![Downloads](https://img.shields.io/packagist/dt/netcreaties/laravel-modulize-api.svg
)](https://packagist.org/packages/netcreaties/laravel-modulize-api)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/RFreij/laravel-modulize-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/RFreij/laravel-modulize-api/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/RFreij/laravel-modulize-api/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/RFreij/laravel-modulize-api/?branch=master)

This package gives you the ability to create synchronization files and prevent you from having to write one time use commands when you've got for example: A database structure change that will require you to modulize-api the old structure data with the new structure.

## Documentation
- [Laravel Modulize API](#laravel-modulize-api)
  - [Documentation](#documentation)
  - [Installation](#installation)
      - [Laravel 5.5+](#laravel-55)
  - [Getting started](#getting-started)
      - [Publish config](#publish-config)
  - [Usage](#usage)

<a name="installation"></a>
## Installation

The best way to install this package is through your terminal via Composer.

Run the following command from your projects root
```shell
composer require netcreaties/laravel-modulize-api
```

#### Laravel 5.5+
This package supports package discovery.

---

<a name="getting-started"></a>
## Getting started

#### Publish config
Publishing the config will enable you to overwrite some of the settings this package uses. For example you can define where modules should be stored.
```shell
php artisan vendor:publish --provider="LaravelModulize\\Providers\\ModulizeServiceProvider" --tag="config"
```

<a name="usage"></a>
## Usage

