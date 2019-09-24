# aviorco-btc-wallet
Test project for Aviorco


Step 1. Run bitgo-express docker container: 

```
docker run -it -p 3080:3080 bitgosdk/express:latest
```

Step 2. Obtain Access token from test.bitgo.com 

Step 3. Edit .env file variables. Example: 

```
APP_NAME=AviorcoWallet
APP_ENV=local
APP_KEY=base64:indg082+8S6UVEWVHw8tzZk0OuRREe9GHdPmuNOBEdM=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=remotemysql.com
DB_PORT=3306
DB_DATABASE=jyOkurUGcG
DB_USERNAME=jyOkurUGcG
DB_PASSWORD=nrDBAPzBEC

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
 

BITGO_API_URL=http://localhost:3080/
BITGO_API_KEY=v2x7e4295b71fed22653062900f0e381b81c5949e5a7f8ea72ee72879b67d9016b1
```

Step 4. Assuming that PHP, Composer and NPM are already setup on machine
```
composer install
```

Step 5. 
```
npm install
```

Step 6. Set app-key
```
php artisan key:generate
```

Step 7. Run migrations
```
php artisan migrate
```

Step 8. Build resources
```
npm run dev
```

Step 9.
```
php artisan serve
```

