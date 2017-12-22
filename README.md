# Running
## Via vagrant
```bash
vagrant up
vagrant provision
vagrant ssh
```

## Via docker
```bash
docker-compose up -d --build
docker exec -it memc-client composer update
docker exec -it memc-client vendor/bin/phpunit --bootstrap vendor/autoload.php tests/
```