# Wordpress Autopublish
Cron script to automatically publish the earliest pending post if there is no published post in defined interval

## Installation
- Git clone the repository [wordpress-autopublish](https://github.com/dragonprojects/wordpress-autopublish.git)
- Add a ".htaccess" file with the environment variables contains the interval and the path to the wordpress installation
```
SetEnv INTERVAL 604800
SetEnv WORDPRESS_PATH path/to/the/wordpress/installation
```
