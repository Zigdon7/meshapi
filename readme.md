<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

# Project
This project is the backend of the 

- PHP 7 FPM
- Nginx web server
- Mysql database
- Redis for cache

## Getting Started
1. Install Docker 
2. Clone the project onto your computer and open a command prompt or terminal in the directory
3. Start up your docker containers using `docker-compose up -d nginx mysql redis workspace`
4. Run your composer install using `docker-compose exec workspace composer install`
5. Do your Database migrations using `docker exec mesh_workspace_1 php artisan migrate`(NOTE: The container name workspace may be different for each user. Run `docker ps` to get a list of all running containers to find your container name)
	a. You can ssh into the workspace box using `docker exec -it mesh_workspace_1 bash`(NOTE: If on windows, please download and install mintty and use the command `winpty docker exec -it mesh_workspace_1 bash`)
6. Go to http://localhost:8080 to look at your project (NOTE: Address will be different if you are using dockertool box)

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
