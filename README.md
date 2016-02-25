StartMeUp app
=============

I. About
--------

This app is made as a proof of concept by [Artevelde University College Ghent][artevelde] as part of a project-based scientific research project.

### Project Team

 - Karijn Bonne       (Lecturer/Researcher)
 - Christel De Maeyer (Lecturer/Researcher, project lead)
 - Olivier Parent     (Lecturer/Researcher, design and development)

### Contributors

 - Lies Van Assche (Student, graphic design)
 - Orphée Alliet   (Student, graphic design)

II. Installation
----------------

### Local Development Environment

 - Use [Artevelde Laravel Homestead][artestead].

#### Configuration 

```
$ artestead make --type laravel
```

```
$ vagrant up
```

#### Install Dependencies

1. Clone the project and go to the folder.

```
$ cd ~/Code/
$ git clone http://github.com/olivierparent/startmeup.local
$ cd ~/Code/startmeup.local/www/
```


2. Update Composer

```
$ composer self-update
```


3. Install the Composer packages (`composer.lock`) and then update them

```
$ composer create-project
$ composer update
```


4. Install Node packages

```
$ npm install
```


5. Install Bower packages

```
$ bower install
```


6. Login to the Artevelde Laravel Homestead sever via SSH


```
$ vagrant ssh
```

8. Initialize the database (create the database) and then run the Migrations (create database tables) and Seeders (populate the database tables with data)

```
vagrant@startmeup$ cd ~/startmeup.local/www/
vagrant@startmeup$ artisan artevelde:database:init --seed
```

### Pages

 - **API**
    - http://www.startmeup.arteveldehogeschool.local/api/v1
 - **Backoffice**
    - http://www.startmeup.arteveldehogeschool.local/backoffice
 - **Frontoffice**
    - http://www.startmeup.local
    - http://www.startmeup.local/frontoffice#/gamification
    - http://www.startmeup.local/frontoffice#/goals
    - http://www.startmeup.local/frontoffice#/moods
    - http://www.startmeup.local/frontoffice#/nearby
    - http://www.startmeup.local/frontoffice#/settings
 - **Style Guide**
    - http://www.startmeup.local/styleguide

[artevelde]:    http://www.arteveldehogeschool.be/en
[artestead]:    https://github.com/gdmgent/artestead/
