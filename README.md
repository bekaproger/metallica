To set up the project run these commands below
1. install ```docker``` and ```docker-compose```
2. pull this repository
3. go to project's folder
4. run ```make```

Then set required environment variables in ```.env.production``` file

```
APP_ENV=production
MAILER_FROM=
MAILGUN_KEY=
MAILGUN_DOMAIN=
MAILER_DSN=mailgun+api://${MAILGUN_KEY}:${MAILGUN_DOMAIN}@default

TEST_MAILER_TO=

YAHOO_API_URI=
YAHOO_API_KEY=
YAHOO_API_HOST=
```