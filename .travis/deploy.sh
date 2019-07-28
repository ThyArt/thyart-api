if [[ "$TRAVIS_BRANCH" == 'dev' ]];
then
  rsync -r --delete-after --quiet "$TRAVIS_BUILD_DIR"/ root@staging.api.thyart.fr:/var/www/thyart-api/
  ssh root@staging.api.thyart.fr php /var/www/thyart-api/artisan deploy
  ssh root@staging.api.thyart.fr php /var/www/thyart-api/artisan migrate --env=testing

elif [[ "$TRAVIS_BRANCH" == 'master' ]];
then
  rsync -r --delete-after --quiet "$TRAVIS_BUILD_DIR"/ root@api.thyart.fr:/var/www/thyart-api/
  ssh root@api.thyart.fr php /var/www/thyart-api/artisan deploy
fi