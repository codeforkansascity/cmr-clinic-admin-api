#!/bin/sh
    php artisan auth:clear-resets
    php artisan permission:cache-reset
    php artisan route:clear
    php artisan view:clear
    php artisan config:clear;
    php artisan cache:clear
    php artisan clear-compiled
    php artisan config:cache
