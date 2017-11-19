
# ASN Lookup

This is a testing Laravel + Docker project. It pulls the data from ftp://ftp.apnic.net/apnic/stats/apnic/delegated-apnic-latest and import into a MySQL database. This project comes with a Auth section for user and api_token management. To use the API function, user needs to register first.

<p>&nbsp;</p>
<p>&nbsp;</p>

## Pre-requisites
* Host machine has stable internet connectivity.
* Port 33306, 8088 are available on the host machine.
* Git has been installed on the host machine.
* Docker is running on the host machine.
* Basic knowledge of Docker.

<p>&nbsp;</p>

## Installation
To get started, the following steps needs to be taken:
* Clone the repo `https://github.com/Alvin1234567/ASNlookup`
* Change to the directory `cd ASNlookup`
* Run `docker-compose up -d` to start the containers.
* Update project dependencies:
  1. Run `docker ps -a` to view all the containers status
  2. Access asnlookup_web container by `docker exec -it {asnlookup_web CONTAINER ID} bash` and run the following:
    ```bash
      composer update
    ```
    if see `The "https://packagist.org/packages.json" file could not be downloaded` error, please check [here](https://stackoverflow.com/questions/40091610/composer-update-not-working-since-installing-ssl-certificate)
    
* Update database connections:
  Access asnlookup_mysql container by `docker exec -it {asnlookup_mysql CONTAINER ID} bash` and get the ip address, run `ip add`, the ip address normally showing as 172.18.0.`*`/16.
* Setup database connection from asnlookup_web container, run :
  ```bash
    docker exec -it {asnlookup_web CONTAINER ID} bash
    vi .env
  ```
  In the .env file, update this section:
  ```bash
    DB_CONNECTION=mysql
    DB_HOST={asnlookup_mysql ip}
    DB_PORT=3306
    DB_DATABASE=homestead
    DB_USERNAME=root
    DB_PASSWORD=root
  ```
* Migrate database and pull the data:
  Access asnlookup_web container by `docker exec -it {asnlookup_web CONTAINER ID} bash` and run the following:
  ```bash
    php artisan migrate:install
    php artisan migrate
    curl http://localhost:80/apnics/init
  ```
* Visit **http://localhost:8088** from the host machine to create an api user.
* Get the api_token through the database running in asnlookup_mysql container which is stored in the api_token field of homestead.users table. Or connect the database throught post 33306 from the host machine.


<p>&nbsp;</p>

## Run the API
Run the api from the host machine: `curl --data "api_token={api_token}&type=asn&year=2016&country=cn&search_type=total" http://localhost:8088/api/apnics/search` or use [postman](https://www.getpostman.com/).

Run the api from asnlookup_web container: `curl --data "api_token={api_token}&type=asn&year=2016&country=cn&search_type=total" http://localhost:80/api/apnics/search`.

<p>&nbsp;</p>

## Troubleshooting
* Port number might be already in use, change from `8088` to another number in `docker-compose.yml` file.
* If there are container name conflicts, update the *container_name* value for that container in the `docker-compose.yml` file. 
* If have any other issues, [report them](https://github.com/Alvin1234567/ASNlookup/issues).

<p>&nbsp;</p>

## Improvements
* unit testing.
* API documentation.
* API access log and performance log.
* api_token revoke or similar management features.
* OAuth 2.0 to replace the current user creation process.
* Release postman collection.

