SimpleCsv
=========

This is a small class to export quickly CSV files.

How to use it
-------------------------

Let's see a basic example :

```php
$header = array(
    'Name',
    'Age'
);
$line = array(
    'Louis',
    '27'
);
$csv = new SimpleCsv();
$csv->writeLine($header);
$csv->writeLine($line);
$csv->show('thats-me');
```
