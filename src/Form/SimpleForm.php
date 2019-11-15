<?php

namespace Drupal\activities_d8\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\activities_d8\DatabaseOperations;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 */
class SimpleForm extends FormBase {

  /**
   *
   */
  public function __construct(DatabaseOperations $db_wrapper) {
    $this->dbWrapper = $db_wrapper;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'simple_form';
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @return \Drupal\Core\Form\FormBase|void
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('activities.database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    if (!empty($this->dbWrapper->fetch())) {
      $last_record = $this->dbWrapper->fetch();
      $first_name = $last_record[0]->first_name;
      $last_name = $last_record[0]->last_name;
    }
    else {
      $first_name = '';
      $last_name = '';
    }
    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => t('First Name:'),
      '#required' => TRUE,
      '#default_value' => $first_name,
    ];
    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => t('Last Name:'),
      '#default_value' => $last_name,
      '#required' => TRUE,
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('first_name')) < 5) {
      $form_state->setErrorByName('first_name', $this->t('First name is too short.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->dbWrapper->store($form_state->getValue('first_name'), $form_state->getValue('last_name'));
    drupal_set_message($form_state->getValue('first_name') . ': Value submitted successully');
  }

}
