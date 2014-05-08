#field-dresser

Field Dresser was built to get the column names and properties from a database, or retrieve the column field names and properties from a supported framework.

##README Contents

* [Installation](#install)
	* [Requirements](#requirements)
	* [Install With Composer](#install-composer)
* [Usage](#usage)
	* [Model Path](#model_path)
	* [Model Name](#model_name)
	* [Database Config & Table Name](#database_config)

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
<br>
<a name="model_path"/>
####Provide a path to a model
	Provide an absolute path to a supported model (Laravel Eloquent default), and get back the fields and properties in array format

<br>
<a name="model_name"/>
####Provide a model name
	Provide a model name, that has already been loaded, and get back the fields and properties in array format

<br>
<a name="database_config"/>
####Provide a database config and table name
	Provide a table name, database config, and get back the fields and properties in array format