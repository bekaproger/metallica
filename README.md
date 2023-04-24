To set up the project run these commands below
1. install ```docker``` and ```docker-compose```
2. pull this repository
3. go to project's folder
4. run ```make```
5. run ```docker-compose run --rm fpm npm install```
6. run ```docker-compose run --rm fpm npm run build```

Then set required environment variables in ```.env.production``` file

```
APP_ENV=local
MAILER_FROM=
MAILGUN_KEY=
MAILGUN_DOMAIN=
MAILER_DSN=mailgun+api://${MAILGUN_KEY}:${MAILGUN_DOMAIN}@default

YAHOO_API_URI=
YAHOO_API_KEY=
YAHOO_API_HOST=
```

Then visit http://localhost:8006
