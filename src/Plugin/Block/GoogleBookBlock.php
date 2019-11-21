<?php

namespace Drupal\activities_d8\Plugin\Block;

use AntoineAugusti\Books\Fetcher;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use GuzzleHttp\Client;

/**
 * Provides a 'D8GoogleBooksBlock' block.
 *
 * @Block(
 *  id = "d8google_books_block",
 *  admin_label = @Translation("D8google books block"),
 * )
 */
class GoogleBookBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['isbn'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ISBN'),
      '#description' => $this->t('Enter ISBN for the book.'),
      '#default_value' => $this->configuration['isbn'],
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['isbn'] = $form_state->getValue('isbn');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $client = new Client(['base_uri' => 'https://www.googleapis.com/books/v1/']);
    $fetcher = new Fetcher($client);
    $book = $fetcher->forISBN('0451526538');
    $build['GoogleBookBlock']['#markup'] = '<p><b>Book title:</a> ' . $book->title . '</p><p><b>Page count:</b> ' . $book->pageCount . '</p>';
    return $build;
  }

}
