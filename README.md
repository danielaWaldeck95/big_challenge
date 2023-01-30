## Installation & Setup
To install the application's dependencies navigate to the application's directory and execute the following command. 

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

If you have troubles connecting your DB:
```
docker-compose down --volumes
```
And then: 
```
sail up --build
```
