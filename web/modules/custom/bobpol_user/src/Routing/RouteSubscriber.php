<?php
/**
 * @file
 * Contains \Drupal\bobpol_user\Routing\RouteSubscriber.
 */

namespace Drupal\bobpol_user\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  public function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('entity.user.edit_form')) {
      $route->setOption('_admin_route', 'FALSE');
    }
  }
}
