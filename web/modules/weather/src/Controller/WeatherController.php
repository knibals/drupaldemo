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

    $config = \Drupal::config('weather.settings');

    $key = $config->get('api.key');
    $endpoint = $config->get('api.endpoint');

    $url = sprintf("%s?q=%s&appid=%s&units=metric", $endpoint,$city, $key);
    if (!empty($country)) {
      $url = sprintf("%s?q=%s,%s&appid=%s&units=metric", $endpoint, $city, $country, $key);
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
