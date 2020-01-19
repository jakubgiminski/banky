# Banky
## Online banking for a made-up bank. It's fake.

### Overview
Banky is an application that allows users to register new bank customers and keep track of their money transactions.
Banky also provides reporting of daily transaction summaries for the last seven days.

### Domain Rules
On registration, every customer is given a random bonus of 5 to 20 percent. Every third deposit is awarded with
a transaction bonus which is calculated by multiplying the deposit amount by the registration bonus. Bonus money cannot
be withdrawn. 

### Installation
Banky is a PHP application depending on a MySQL database. Make sure you're using the minimal required versions, which are 7.4.1
for PHP and 14.14 (5.1.73) for MySQL.

Clone the repository and run `composer install` from within it in order to install project's dependencies. 

Edit contents of the `src/databaseConfig.php` file appropriately (make sure the database you enter exists), 
then run `php bootstrapDatabase.php` which recreates the database and applies the SQL schema.

Finally, use a server in order to serve the app. You can choose whichever one you want but using the PHP's built 
in server is the simplest.
```php -S localhost:8000 -t .```

### API Documentation
@todo



