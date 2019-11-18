<?php

namespace Drupal\activities_d8\Plugin\Block;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\activities_d8\WeatherData;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Weather' Block.
 *
 * @Block(
 *   id = "weather_block",
 *   admin_label = @Translation("weather block"),
 *   category = @Translation("weather block"),
 * )
 */
class OpenWeatherBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var WeatherManager
   */
  private $weatherData;

  /**
   *
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, WeatherData $weatherData) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->weather_data = $weatherData;
  }

  /**
   *
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('activities.weather_data')
    );
  }

  /**
   *
   */
  public function build() {
    $city_weather_data = $this->weather_data->fetchWeatherData($this->configuration['city']);
    return [
      '#theme' => 'weather_design',
      '#temp' => $city_weather_data['temp'],
      '#pressure' => $city_weather_data['pressure'],
      '#humidity' => $city_weather_data['humidity'],
      '#temp_min' => $city_weather_data['temp_min'],
      '#temp_max' => $city_weather_data['temp_max'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['city_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City name'),
      '#default_value' => $this->getConfiguration()['city'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('city', $form_state->getValue('city_name'));
  }

}
