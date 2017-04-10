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


How to run the e2e Testing Local
==================

In the local development you will need to bring up the phantomjs
```bash
app/e2e/phantomjs --webdriver=4444
```
After that, you will need to start the php built in server
```bash
php -S 127.0.0.1:8542
```

Now you can use codeceptjs to run the tests
```bash
cd app/e2e
codeceptjs run --steps
```


npm install -g codeceptjs
npm install -g webdriverio
http://codenroll.it/acceptance-testing-with-codecept-js/
http://codecept.io/acceptance/
