[![Build Status](https://travis-ci.org/diego3/telefonia.svg?branch=master)](https://travis-ci.org/diego3/telefonia)
[![Coverage Status](https://coveralls.io/repos/github/diego3/telefonia/badge.svg)](https://coveralls.io/github/diego3/telefonia)


First of all, in order to be able to run the phpunit tests you need to create the data base schema 

Without that the tests will fail!

How to run the phpunit tests
===========
```bash
phpunit app/api/tests  --testdox
```


How to run the phpunit code coverage
===========
```bash
phpunit app/api/tests  --coverage-html ./phpcoverage
```


