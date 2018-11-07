## Usage instructions
- run docker-composer up
- open PhpMyAdmin and upload the sqldump.sql
- run you tests


# DOCKER LEMP
- Nginx
- PHP 7.2-fpm
- MySQL
- PHPMyAdmin
- Maildev

## :rocket: Quickstart 
- Install and launch Docker  
- `cp .env.dist .env`  
- `docker-compose up`

| Service      | Path                    |
| ------------ | ----------------------- |
| Website      | `http://localhost:8080` | 
| PhpMyAdmin   | `http://localhost:8081` |
| Mail catcher | `http://localhost:8082` |
| Logs         | `log/`                  |

## About MySQL credentials
If you change mysql credentials in .env you have to re-create mysql container:
- Database will be deleted, make a dump with PhpMyAdmin
- Remove container and volume : `$ docker-compose rm -fv mysql`
- Run : `docker-compose up` 
- Re-import your database on PhpMyAdmin






