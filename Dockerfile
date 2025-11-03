# Set the base image 
FROM munichventures/php:8.3
RUN apt-get update && apt-get install -y bash libxml2-dev cron 
RUN docker-php-ext-install soap

WORKDIR /var/www/app
COPY  ./  /var/www/app 
RUN echo "* * * * * /usr/local/bin/php /var/www/app/artisan schedule:run >> /var/log/cron.log 2>&1" > /etc/cron.d/laravel-scheduler
RUN chmod 0644 /etc/cron.d/laravel-scheduler
RUN crontab /etc/cron.d/laravel-scheduler
COPY ./.github/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
RUN cp /var/www/app/.github/app-nginx.conf /etc/nginx/conf.d/ 
RUN mkdir -p  /etc/letsencrypt/
RUN ls ./.github/ssl/bodies.munich.dev
COPY ./.github/ssl/ /etc/letsencrypt/
RUN ls /etc/letsencrypt/bodies.munich.dev
RUN chmod 644 -R /etc/letsencrypt/
RUN nginx -t
RUN service nginx start

RUN /root/.config/composer/vendor/bin/envoy run  $deployvar

EXPOSE 80 443 9000
CMD ["/usr/local/bin/start.sh"]
