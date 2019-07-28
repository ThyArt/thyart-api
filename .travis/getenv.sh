if [ "$TRAVIS_BRANCH" == 'feature/travis' ];
then
  aws s3 cp s3://thyart-ops/env/api/staging/.env .env
  aws s3 cp s3://thyart-ops/env/api/staging/.env.testing .env.testing
  aws s3 cp s3://thyart-ops/env/api/staging/oauth-private.key storage/oauth-private.key
  aws s3 cp s3://thyart-ops/env/api/staging/oauth-public.key storage/oauth-public.key

elif [ "$TRAVIS_BRANCH" == 'master' ];
then
  aws s3 cp s3://thyart-ops/env/api/production/.env .env
  aws s3 cp s3://thyart-ops/env/api/production/oauth-private.key storage/oauth-private.key
  aws s3 cp s3://thyart-ops/env/api/production/oauth-public.key storage/oauth-public.key
fi
