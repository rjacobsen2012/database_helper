#field-dresser

Field Dresser was built to get the column names and properties from a database, or retrieve the column field names and properties from a supported framework.

##README Contents

* [Installation](#install)
	* [Requirements](#requirements)
	* [Install With Composer](#install-composer)
* [Usage](#usage)
	* [Model Path](#model_path)
	* [Model Name](#model)
	* [Database Config & Table Name](#database)
* [Defaults](#defaults)
* [Add new model framework support](#add_framework)
* [Add new database type support](#add_database)

<a name="install"/>	
##Installation


<a name="requirements"/>
###Requirements

- Any version of PHP 5.4+

<a name="install-composer"/>
### Install With Composer

You can install the library via [Composer](http://getcomposer.org) by adding the following line to the **require** block of your *composer.json* file:

````
"database/field-dresser": "dev-master"
````

Next run `composer install`, or `composer update` if you already have composer installed.

Then run `composer dumpautoload` to load the classes.

<a name="usage">
##Usage

To use field-dresser to get your fields, you can either load them from an existing [model](#model), [model path](#model_path), or a [database](#database).

<a name="model">
###Get fields from a model
Simply make provide the model name to the field-dresser as follows:

```
Example: 

$mapper = new Mapper();
$fields = $mapper->getFields("UserModel");

```
The model you provide will have to already be auto-loaded so it can load a new instance to get the fields. The package uses Laravel Eloquent by default.

<br>
<a name="model_path">
###Get fields from the path to a model
Simply make provide the absolute path to a model, and the package will attempt to locate the file, auto-load it, and create a new instance to get the fields.

```
Example: 

$mapper = new Mapper();
$fields = $mapper->getFields("/path/to/UserModel");

```

<br>
<a name="database"/>
###Provide a database config and table name
Provide a table name, database config, and get back the fields and properties in array format.

```
Example:

$mapper = new Mapper();
$mapper->setDbConfig(
				'mysql',
				'111.12.123.1',
				'someuser',
				'password',
				'database_name',
				'port'(optional),
				'socket'(optional)
			);
$fields = $mapper->getFields('Usertable');
```

<br>
<a name="defaults">
###Defaults
The package comes with the following defaults.
	<br><br>
	```Models```: The package uses Laravel Eloquent by default to load the fields for a given model. [How to add a new model framework](#add_framework)
	<br><br>
	```Databases```: The package uses the "mysql" database configuration by default. [How to add support for a new database](#add_database)
	
<br>
<a name="add_framework">
###Add New Model Framework Support

To add support for a new model framework, you will need to do the following:

	1. Add a new model driver under "src/Drivers". (you can use "src/Drivers/Laravel/LaravelService.php" as a guide)
	2. Add the framework to the "src/Validators/ModelValidator.php".
	3. Make sure to add tests for your new framework.
	
When adding a new model framework, please be sure to follow [Solid](http://en.wikipedia.org/wiki/SOLID) design principles, do not have any commented out code or debug code, and be sure to comment/document your code well so I can understand what you did. This will help get your changes merged in quickly.

<br>
<a name="add_database">
###Add New Database Type Support

To add support for a new database type, you will need to do the following:

	1. Add a new database repository to "src/Drivers/Database". Simply create a directory in there for your new database type (example: "src/Drivers/Database/Postgres/PostgresRepository").
	2. Add the repository to the valid repositories in "src/Validators/DatabaseValidator.php".
	3. Make sure to add tests for your new database type. Along with your tests, be sure to create fixtures so the package does not need to actually connect to a database.
	
When adding a new database type, please be sure to follow [Solid](http://en.wikipedia.org/wiki/SOLID) design principles, do not have any commented out code or debug code, and be sure to comment/document your code well so I can understand what you did. This will help get your changes merged in quickly.