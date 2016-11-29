# stackoverflow Jobs Client

[![Latest Version](https://img.shields.io/github/release/jobapis/jobs-stackoverflow.svg?style=flat-square)](https://github.com/jobapis/jobs-stackoverflow/releases)
[![Software License](https://img.shields.io/badge/license-APACHE%202.0-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/jobapis/jobs-stackoverflow/master.svg?style=flat-square&1)](https://travis-ci.org/jobapis/jobs-stackoverflow)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/jobapis/jobs-stackoverflow.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobapis/jobs-stackoverflow/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/jobapis/jobs-stackoverflow.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobapis/jobs-stackoverflow)
[![Total Downloads](https://img.shields.io/packagist/dt/jobapis/jobs-stackoverflow.svg?style=flat-square)](https://packagist.org/packages/jobapis/jobs-stackoverflow)

This package provides [Stack Overflow Careers](https://stackoverflow.com/jobs) RSS feed support for [Jobs Common](https://github.com/jobapis/jobs-common).

## Installation

To install, use composer:

```
composer require jobapis/jobs-stackoverflow
```

## Usage
Create a Query object and add all the parameters you'd like via the constructor.
 
```php
// Add parameters to the query via the constructor
$query = new JobApis\Jobs\Client\Queries\StackoverflowQuery();
```

Or via the "set" method. All of the parameters documented in Indeed's documentation can be added.

```php
// Add parameters via the set() method
$query->set('q', 'engineering');
```

You can even chain them if you'd like.

```php
// Add parameters via the set() method
$query->set('l', 'Chicago, IL')
    ->set('pg', '2');
```
 
Then inject the query object into the provider.

```php
// Instantiating a provider with a query object
$client = new JobApis\Jobs\Client\Provider\StackoverflowProvider($query);
```

And call the "getJobs" method to retrieve results.

```php
// Get a Collection of Jobs
$jobs = $client->getJobs();
```

The `getJobs` method will return a [Collection](https://github.com/jobapis/jobs-common/blob/master/src/Collection.php) of [Job](https://github.com/jobapis/jobs-common/blob/master/src/Job.php) objects.

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/jobapis/jobs-stackoverflow/blob/master/CONTRIBUTING.md) for details.


## Credits

- [Karl Hughes](https://github.com/karllhughes)
- [All Contributors](https://github.com/jobapis/jobs-stackoverflow/contributors)


## License

The Apache 2.0. Please see [License File](https://github.com/jobapis/jobs-stackoverflow/blob/master/LICENSE) for more information.
