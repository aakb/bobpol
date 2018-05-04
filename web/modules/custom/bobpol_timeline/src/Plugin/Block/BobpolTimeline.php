<?php
/**
 * @file
 * Implements timeline block
 */

namespace Drupal\bobpol_timeline\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides timeline content.
 *
 * @Block(
 *   id = "bobpol_timeline",
 *   admin_label = @Translation("Bobpol timeline"),
 * )
 */
class BobpolTimeline extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = \Drupal::getContainer()->get('bobpol_timeline.settings')->getAll();
    $nid = \Drupal::routeMatch()->getParameter('node')->id();

    if (isset($config['node_ref']) && $nid == $config['node_ref']) {
      return array(
        '#type' => 'markup',
        '#theme' => 'bobpol_timeline_block',
        '#config' => $config,
      );
    }
    return NULL;
  }
}
