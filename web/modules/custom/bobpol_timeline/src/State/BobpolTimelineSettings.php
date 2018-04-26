<?php
/**
 * @file
 * Contains key/value storage for bobpol_timeline settings.
 */

namespace Drupal\bobpol_timeline\State;

use Drupal\Core\KeyValueStore\DatabaseStorage;
use Drupal\Component\Serialization\SerializationInterface;
use Drupal\Core\Database\Connection;

class BobpolTimelineSettings extends DatabaseStorage {
  /**
   * @param \Drupal\Component\Serialization\SerializationInterface $serializer
   * @param \Drupal\Core\Database\Connection $connection
   */
  public function __construct(SerializationInterface $serializer, Connection $connection) {
    parent::__construct('bobpol_timeline.settings', $serializer, $connection);
  }
}
