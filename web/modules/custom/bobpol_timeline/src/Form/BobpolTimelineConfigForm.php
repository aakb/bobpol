<?php
/**
 * @file
 * Configuration form for the bobpol timeline module.
 */

namespace Drupal\bobpol_timeline\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

/**
 * Configuration form for the bobpol timeline module.
 */
class BobpolTimelineConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'bobpol_timeline_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['bobpol_timeline.config'];
  }

  /**
   * Get key/value storage for base config.
   *
   * @return object
   */
  private function getSettings() {
    return \Drupal::getContainer()->get('bobpol_timeline.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $settings = $this->getSettings();
    $node_reference = Node::load($settings->get('node_ref'));
    $form['general'] = [
      '#type' => 'details',
      '#open' => TRUE,
      '#title' => t('General settings'),
    ];

    $form['general']['node_ref'] = array(
      '#title' => $this->t('Timeline page'),
      '#type' => 'entity_autocomplete',
      '#target_type' => 'node',
      '#default_value' => $node_reference,
      '#description' => t('Choose which page to add the timeline to'),
      '#weight' => '6',
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Save to config.
    // Set the configuration values.
    $this->getSettings()->setMultiple(array(
      'node_ref' => $form_state->getValue('node_ref'),
    ));

    drupal_flush_all_caches();
  }
}
