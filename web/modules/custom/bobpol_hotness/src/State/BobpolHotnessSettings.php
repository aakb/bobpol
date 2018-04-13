<?php
/**
 * @file
 * Contains key/value storage for bobpol_hotness settings.
 */

namespace Drupal\bobpol_hotness\State;

use Drupal\Core\KeyValueStore\DatabaseStorage;
use Drupal\Component\Serialization\SerializationInterface;
use Drupal\Core\Database\Connection;

class BobpolHotnessSettings extends DatabaseStorage {
  /**
   * @param \Drupal\Component\Serialization\SerializationInterface $serializer
   * @param \Drupal\Core\Database\Connection $connection
   */
  public function __construct(SerializationInterface $serializer, Connection $connection) {
    parent::__construct('bobpol_hotness.settings', $serializer, $connection);
  }
}
