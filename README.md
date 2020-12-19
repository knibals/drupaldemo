# Drupal demo project

This is a demo projet to showcase some of Drupal competencies.
I use an Dockerized installation to ease the setup and because Docker and Git are nowaday the basic requirement for any developper.

I don't (always) like to reinvent the wheel, so I'll use a very robust and well-maintened [Wodby's Drupal4 Docker](https://github.com/wodby/docker4drupal) stack.

## Installation

This project use Drupal config manager ([Config API](https://www.drupal.org/docs/drupal-apis/configuration-api/configuration-api-overview)) because SQL files versionning is so Drupal 7...

### Bootstraping in three steps

0. Boot the containers `docker-compose up -d` or `make up`
1. Enter into the PHP container `make shell php` 
2. and install the site from configuration `drush site-install --existing-config`
3. That's it! Go check the `/weather`

