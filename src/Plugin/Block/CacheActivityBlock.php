<?php

namespace Drupal\activities_d8\Plugin\Block;

use Drupal\node\Entity\Node;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\Query\QueryFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "cache_activity_block",
 *   admin_label = @Translation("Cache Activity Block"),
 * )
 */
class CacheActivityBlock extends BlockBase implements ContainerFactoryPluginInterface{

  protected $entityQuery; 
  /**
   *
   */
  public function __construct(array $configuration,
    $plugin_id,
    $plugin_definition, 
    QueryFactory $entityQuery) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityQuery = $entityQuery;
  }

  /**
   *
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
       $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity.query')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $query = $this->entityQuery->get('node')
      ->condition('status', 1)
      ->condition('type', 'article')
      ->sort('nid', 'DESC')
      ->range(0, 3);
    $nids = $query->execute();

    foreach ($nids as $nid) {
      $node = Node::load($nid);
      $titles[] = ['#markup' => $node->title->value];
      $tags[] = 'node:' . $node->id();
    }

    $build['item_list'] = [
      '#theme' => 'item_list',
      '#list_type' => 'ul',
      '#items' => $titles,
      '#cache' => [
        'tags' => array_merge($tags, ['node_list']),
      ],
    ];
    return $build;
  }

}
