<?php

namespace Drupal\activities_d8\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CacheContextBlock.
 *
 * @package Drupal\activities_d8\Plugin\Block
 *
 * @Block(
 *   id = "cache_context_block",
 *   admin_label = @Translation("Cache context Block")
 * )
 */
class CacheContextBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * @var \Drupal\Core\Session\AccountProxy
   */
  private $account;

  /**
   * CacheContextBlock constructor.
   *
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param \Drupal\Core\Session\AccountProxy $account
   */
  public function __construct(array $configuration,
                              $plugin_id,
                              $plugin_definition,
                              AccountProxy $account) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->account = $account;
  }

  /**
   *
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user')
    );
  }

  /**
   *
   */
  public function build() {
    return [
      '#markup' => $this->account->getEmail(),
      '#cache' => [
        'contexts' => ['session', 'user'],
      ],
    ];
  }

}
