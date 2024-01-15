# Covidstats API

Backend ETL application to store Covid-19 data from different sources snd retrieve them through JSON Api.

## Project setup
You will require docker and docker-compose installed, you have also to be able to execute make files on your development machine
1) clone the repository from github
```bash
git clone git@github.com:davidefossacecchi/covidstats-api.git
```

2) move to the project folder and run the mak up command
```bash
cd covidstats-api
make up
```

3) setup the env file with development db credentials
4) connect to the php container, install dependencies and run migrations
```bash
docker-compose exec php sh
composer install
php artisan migrate:up
```

## Store covid data
Covid data extraction can be done through the artisan stats fetch command with some option.
Connect to the php container and run ```php artisan stats:fetch``` to extract data rom the last extraction date for each collection.

- ```--from``` let you specify the start date
```bash
php artisan stats:fetch --from=2020-09-01
```

- ```--only``` let you specify a set of collection to extract the data for
```bash
php artisan stats:fetch --only=region_data
```

- ```--exclude``` lets you exclude a set of collections 
```bash
php artisan stats:fetch --exclude=region_data
```

- ```--refresh``` extract the data again from the beginning
```bash
php artisan stats:fetch --refresh
```
