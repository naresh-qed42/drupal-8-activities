<?php
namespace Drupal\activities_d8;
use Drupal\Core\Database\Connection;

/**
 * Class DrupaliseMe.
 */
class DatabaseOperations {
  /**
   *
   * @var \Drupal\Core\Database\Connection
   */

  protected $database;

  /**
   * Constructs a new DrupaliseMe object.
   *
   * @param \Drupal\Core\Database\Connection $connection
   */
  public function __construct(Connection $connection) {
    $this->database = $connection;
  }

  /**
   *
   */
  public function fetch() {
    return $this->database->select('d8_demo', 'demo')
      ->fields('demo', ['first_name', 'last_name'])
      ->range(0, 1)
      ->orderBy('pid', 'DESC')
      ->execute()->fetchAll();
  }

  /**
   *
   */
  public function store($firstname, $lastname) {
    $result = $this->database->insert('d8_demo')
      ->fields([
        'first_name' => $firstname,
        'last_name' => $lastname,
      ])
      ->execute();
  }

}
