ORM migrations standalone
===========================
Do you like the migrations like laravel or symfony?
But for your current project laravel is overkill,
or it is not in PHP,
but you want to use the beautiful migrations of laravel?

Then you are in the right place.

This repo is your solution for this.
You can easily create your own migrations and run them.
So you can convert them to sql files to insert them in the other locations of your project.

Setup is easy. First clone the repo and run the following command:

```
docker-compose up
```

After this you can move in to the docker container and run the following command:

```
make-migration.sh <name>
```

You can edit fresh created file in /migrations directory.
The syntax is the same as laravel migrations.
https://laravel.com/docs/9.x/migrations#migration-structure

After you finished editing the file you can run the following command inside the docker container:

```
./migrate.sh>
```

This will run the migration and save it in the database. If you connected to the database you can see your changes and
created tables.
When you ar finished you can run the following command to generate the sql files inside your docker container:

```
./export.sh
```
To view your sql files you can visit the following directory:

```
/dumps
```

