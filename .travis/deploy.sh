if [[ "$TRAVIS_BRANCH" == 'dev' && "$TRAVIS_PULL_REQUEST" == 'false' ]];
then
  rsync -r --delete-after --quiet "$TRAVIS_BUILD_DIR"/ root@staging.api.thyart.fr:/var/www/thyart-api/
  ssh root@staging.api.thyart.fr php /var/www/thyart-api/artisan deploy
  ssh root@staging.api.thyart.fr php /var/www/thyart-api/artisan migrate --env=testing
  ssh root@staging.api.thyart.fr chown -R www-data:www-data /var/www/thyart-api/

elif [[ "$TRAVIS_BRANCH" == 'master' && "$TRAVIS_PULL_REQUEST" == 'false' ]];
then
  rsync -r --delete-after --quiet "$TRAVIS_BUILD_DIR"/ root@api.thyart.fr:/var/www/thyart-api/
  ssh root@api.thyart.fr php /var/www/thyart-api/artisan deploy
  ssh root@api.thyart.fr chown -R www-data:www-data /var/www/thyart-api/
fi