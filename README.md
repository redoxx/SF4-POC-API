# SF4-POC-API
Starter SF4 kit : API,  EASYADMIN, CUSTOM COMMAND LINE

Please follow those steps:

1- docker-compose build --no-cache 

2- docker-compose up -d

3- docker exec -ti sf4_php_poc composer install

4- docker exec -ti sf4_php_poc php /home/wwwroot/sf4_poc/bin/console doctrine:schema:update --force

5- In order to run the custom command : 

   docker exec -ti sf4_php_poc php /home/wwwroot/sf4_poc/bin/console app:import-users
   
   docker exec -ti sf4_php_poc php /home/wwwroot/sf4_poc/bin/console app:import-posts
   
6- For admin page go to /admin to list all users and posts
 
7- For User geolocalisation with Open Street Map Leaflet; go to /userGeo page
   
NB : The BD access are configuration in .ENV file (it is commited ^^)
