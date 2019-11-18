<?php

namespace Drupal\activities_d8;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Config\ConfigFactory;
use Exception;
use GuzzleHttp\Client;

/**
 * Class WeatherManager.
 *
 * @package Drupal\activities_d8
 */
class WeatherData {
  /**
   * @var \Drupal\Core\Config\ConfigFactory
   */
  private $configFactory;
  /**
   * @var \GuzzleHttp\Client
   */
  private $client;

  /**
   * WeatherManager constructor.
   *
   * @param \GuzzleHttp\Client $client
   * @param \Drupal\Core\Config\ConfigFactory $config_factory
   */
  public function __construct(Client $client, ConfigFactory $config_factory) {
    $this->client = $client;
    $this->configFactory = $config_factory;
  }

  /**
   * Helper function to fetch weather data based on the city name.
   *
   * @param $city
   *
   * @return mixed
   */
  public function fetchWeatherData($city) {
    $app_id = $this->configFactory->getEditable('weather.settings')->get('activities_d8.settings.appid');
    $url_string = "https://api.openweathermap.org/data/2.5/weather?q=" . $city . "&appid=" . $app_id;
    try {
      $res = $this->client->get($url_string);
      return Json::decode($res->getBody()->getContents())['main'];
    }
    catch (Exception $e) {
      return 'An error occured while fetching data';
    }
  }
}
