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
  
  /**
   * construct the page title
   */
  public function title(string $city, string $country_code){
    if(empty($city)){
      $config = \Drupal::config('weather.settings');
      $city = $config->get('city');
    }
    return $this->t("What's the weather like in %city?", ['%city' => $city]);
  }

  private function _fetch($city, $country_code) {
    
    $config = \Drupal::config('weather.settings');
    
    $key = $config->get('api.key');
    $endpoint = $config->get('api.endpoint');

    // if "$city" is empty (not given from the URL)
    //  1. we don't care about the value of $country_code
    //  2. we take the defaults from Config or DB
    if (empty($city)) {
      $city = $config->get('city'); // using the elvis operator
      $country_code = $config->get('country_code'); // using the elvis operator
    }
    
    $url = sprintf("%s?q=%s&appid=%s&units=metric", $endpoint, $city, $key);
    if (!empty($country_code)) {
      $url = sprintf("%s?q=%s,%s&appid=%s&units=metric", $endpoint, $city, $country_code, $key);
    }
    
    try {
      $client = \Drupal::httpClient();
      $request = $client->request('GET', $url, [
        'headers' => ['Accept-Encoding' => 'gzip'],
        'decode_content' => false,
        'timeout' => 5
      ]);
      return json_decode($request->getBody());
    } catch (\Exception $e) {
      watchdog_exception('weather', $e);
    }
  
  }
}
