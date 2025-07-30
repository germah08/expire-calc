FROM php:8.2-cli

WORKDIR /var/www/html
COPY expire-calc.php .

EXPOSE 10000
CMD ["php", "-S", "0.0.0.0:10000"]
