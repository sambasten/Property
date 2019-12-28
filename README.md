
## Install the Application

### Run this command from the directory in which you want to install your new Application

 composer install

### create a database and copy the contents of the TableStructures schema at dt/Tablestructres.php in it

### Edit db connection parameters in database adapter file at src/Adapter/DatabasAdapter.php

### Switch to public directory and  run script property.php with command
php property.php

### Switch back to Property directory and Launch the php inbuilt server with the command 
php -S localhost:8080 -t public

### After that, open `http://localhost:8080` in your browser.


