#fuelphp.basic note
=============

Everything basic about fuelphp for developing a web system

Config
+ Step 1: 
php oil refine install

+ Step 2:
Database 
C:\xampp\htdocs\fuelphp.basic\fuel\app\config\db.php
ORM
C:\xampp\htdocs\fuelphp.basic\fuel\app\config\config.php

+ Step 3: 
Scaffold
$ php oil g scaffold Model_Name field1:type field2:type

Generating Migrations -> Could be used to rename a table
$ php oil generate migration rename_table_users_to_accounts


+ Step 4: Build MVC
Controller: $ php oil g controller Controller_Name1 Controller_Name2 ..
Model: $ php oil g model Model_Name field1:type[length] field2:text field3:int
View: $ php oil g controller Controller_Name --with-viewmodel
