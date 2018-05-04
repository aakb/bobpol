<?php
/**
 * @file
 * Implements hotness levels block
 */

namespace Drupal\bobpol_hotness\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides hotness levels content.
 *
 * @Block(
 *   id = "bobpol_hotness_levels",
 *   admin_label = @Translation("Bobpol hotness levels"),
 * )
 */
class BobpolHotnessLevels extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#type' => 'markup',
      '#theme' => 'bobpol_hotness_levels_block',
    );
  }
}
