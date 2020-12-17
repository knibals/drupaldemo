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

    return [
      '#theme' => 'weather',
      '#data' => $this->_fetch($city, $country_code),
    ];
    
  }

  private function _fetch($city, $country) {

    $key = "be306854c8951ab7c36943603da82b4d";
    $url = sprintf("api.openweathermap.org/data/2.5/weather?q=%s&appid=%s&units=metric", $city, $key);

    if (!empty($country)) {
      $url = sprintf("api.openweathermap.org/data/2.5/weather?q=%s,%s&appid=%s&units=metric", $city, $country, $key);
    }
    
    try {
      $client = \Drupal::httpClient();
      $request = $client->request('GET', $url);
      return json_decode($request->getBody());
    } catch (\Exception $e) {
      watchdog_exception('weather', $e);
    }
  
  }
}
