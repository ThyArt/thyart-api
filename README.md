#ThyArt API

a PHP Laravel API working with the ThyArt Web Project.

##clone
```
git clone https://git-codecommit.eu-west-1.amazonaws.com/v1/repos/thyart-api --recurse-submodules
```

##creating local environment
```
cp .env.example .env
cp .env.laradock.example thyart-api-docker/.env
```

##install the project
```
cd thyart-api-docker
docker-compose up -d nginx mysql workspace
docker-compose exec workspace ./install.sh
```

##running php artisan commands
```
cd thyart-api-docker
docker-compose exec workspace php artisan {command}
```

##going into the workspace container
```
cd thyart-api-docker
docker-compose exec workspace bash
```

##running tests with phpunit
```
cd thyart-api-docker
docker-compose exec workspace ./vendor/bin/phpunit
```