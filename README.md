# DOCKER + WORDPRESS + RABBITMQ
Sample function is that wordpress posts the current logged in user to the wordpress backend which then posts that same content to the rabbitmq queue `ibl_analytics_event`
The `ibl_analytics_event` is consumed by the `rabbitmq_consumer/consumer.py` and stores it into the `ibl_analytics_event_store` on rabbitmq

## Requirements
1. Docker
2. Php Composer

## Installation
1. Clone repo
2. cd into folder
3. Run `docker-compose up`
4. cd into `<repo-folder>/tijes-plugin`
5. Run `composer install && composer dump-autoload`

## Usage
1. Goto to `localhost:8000` to setup wordpress
2. Goto to `localhost:8000/wp-admin/plugins.php` > Activate `Tijesunimi's Plugin`
3. Goto to Posts/Pages > add `[tije_plugin]` shortcode to the content of the post/page created
4. Goto to webpage of the post/page created, you should see a button that says `Click Me` which will post the user details if logged in to rabbitmq
