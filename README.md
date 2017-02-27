Installation instructions
---

Run the following commands one by one

* `composer install`
* `bin/console doctrine:database:create`
* `bin/console doctrine:migrations:migrate`
* `bin/console doctrine:fixtures:load`
* `bin/console fos:user:create admin admin@example.com admin --super-admin`
* `bin/console api:oauth:client:create admin`
* `php bin/console fos:js-routing:dump`
* `php bin/console assets:install web --symlink`
* `npm install`

In order to get an access token send a request to `/oauth/v2/token?client_id=_id_&client_secret=_secret_&username=admin&password=admin&grant_type=password` where \_\_id\_\_ and \_\_secret\_\_ are your credentials
