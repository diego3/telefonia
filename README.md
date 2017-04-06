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


