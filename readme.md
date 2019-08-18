# Performance Media Test Task

```bash
git clone https://github.com/AkimovSergei/currency-converter.git
```

Modify .env, add converter api key

```
CURRENCY_CONVERTER_API_KEY=912ab7a1c2e95bb2c28b
```


Create database
```
php bin/console doctrine:database:create
```

Migrate database
```
php bin/console doctrine:migrations:migrate
 ```

Build front
```
yarn install
yarn dev
```
 
Run server
```
symfony server:start
```


Open http://127.0.0.1:8000
