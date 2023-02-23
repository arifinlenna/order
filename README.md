## our goals

it's can sending email in background services without know sending email success or not success and without waiting sending email until success.

## publisher

1. Nur Arifin => arifin@lenna.ai

## main tech must being install

1. docker
2. php = 7.4
3. mail account
4. composer

## Dockerize RabbitMQ

-   docker run --rm -it --hostname my-rabbit -p 15672:15672 -p 5672:5672 rabbitmq:3-management

## change mail driver

-   MAIL_DRIVER=sendmail
-   MAIL_HOST=smtp.gmail.com
-   MAIL_PORT=587
-   MAIL_USERNAME=**\*\*\*\***@gmail.com
-   MAIL_PASSWORD=\*\*\*\*\*\*\*\*
-   MAIL_ENCRYPTION=tls
-   MAIL_FROM_ADDRESS="${MAIL_USERNAME}"
-   MAIL_FROM_NAME="${APP_NAME}"

## installing clone project

-   composer install
-   cp .env.example .env
-   php artisan key:generate
-   configure .env
-   php artisan migrate
-   php artisan serve

## management console rabbitmq

-   http://localhost:15672/
-   user: guest
-   pass: guest

### References

1. https://github.com/bschmitt/laravel-amqp/
2. https://medium.com/geekculture/laravel-microservice-communication-using-rabbitmq-message-broker-9972927c6b3b
