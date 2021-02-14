# Test task. Short URLs

- In this task I chose Onion Architecture + DDD. \
- For local environment use docker. \
- Framework symfony \
- For documentation API use Swagger. You can check on this link http://localhost/api/doc on you local server
### Installation:
- Lunch docker `docker-compose up -d`
- Install dependencies `docker exec app composer install`
- Run migrations `docker exec app bin/console doctrine:migrations:migrate`