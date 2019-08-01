if [[ "$TRAVIS_BRANCH" == 'dev' ]];
then
  aws s3 cp s3://thyart-ops/env/backend/staging/.env .env
  aws s3 cp s3://thyart-ops/env/backend/staging/.env.testing .env.testing
  aws s3 cp s3://thyart-ops/env/backend/staging/oauth-private.key storage/oauth-private.key
  aws s3 cp s3://thyart-ops/env/backend/staging/oauth-public.key storage/oauth-public.key

elif [[ "$TRAVIS_BRANCH" == 'master' ]];
then
  aws s3 cp s3://thyart-ops/env/backend/production/.env .env
  aws s3 cp s3://thyart-ops/env/backend/production/oauth-private.key storage/oauth-private.key
  aws s3 cp s3://thyart-ops/env/backend/production/oauth-public.key storage/oauth-public.key
fi
