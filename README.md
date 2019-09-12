# SF4-POC-API
Starter SF4 kit : API,  EASYADMIN, CUSTOM COMMAND LINE

Please follow those steps:
1- docker-compose build --no-cache 
2- docker-compose up -d
3- docker exec -ti sf4_php_poc php /home/wwwroot/sf4_poc/bin/console doctrine:schema:update --force
4- In order to run the custom command : 
   docker exec -ti sf4_php_poc php /home/wwwroot/sf4_poc/bin/console app:import-users
   docker exec -ti sf4_php_poc php /home/wwwroot/sf4_poc/bin/console app:import-posts
5- For admin page go to /admin to list all users and posts
   
NB : The BD access are configuration in .ENV file (it is commited ^^)
