#!/bin/bash

# Start PHP-FPM in the background
php-fpm &

# Start the cron daemon in the background
cron &

# Start Nginx in the foreground
nginx -g "daemon off;"
