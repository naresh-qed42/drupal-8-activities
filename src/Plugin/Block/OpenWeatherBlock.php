<?php

namespace Drupal\activities_d8\Plugin\Block;

use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Weather' Block.
 *
 * @Block(
 *   id = "weather_block",
 *   admin_label = @Translation("weather block"),
 *   category = @Translation("weather block"),
 * )
 */
class OpenWeatherBlock extends BlockBase implements BlockPluginInterface {

  /**
   *
   */
  public function build() {
    return [
      '#markup' => $this->t('Hello, World!'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['city_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City name'),
      '#description' => $this->t('Enter city name to dispaly the weather information.'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['hello_block_name'] = $values['hello_block_name'];
  }

}
