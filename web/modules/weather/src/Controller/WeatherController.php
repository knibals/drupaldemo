<?php

namespace Drupal\weather\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for weather routes.
 */
class WeatherController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build(string $city, string $country_code) {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->_fetch($city, $country_code),
    ];

    return $build;
  }

  private function _fetch($city, $country = null) {

    return "The weather in " . $city . " (" . $country . ") is ...";
  // if is_null($country):
  
  // api.openweathermap.org/data/2.5/weather?q={city name}&appid={API key}
  // api.openweathermap.org/data/2.5/weather?q={city name},{state code}&appid={API key}
  // api.openweathermap.org/data/2.5/weather?q={city name},{state code},{country code}&appid={API key}
 }
}
