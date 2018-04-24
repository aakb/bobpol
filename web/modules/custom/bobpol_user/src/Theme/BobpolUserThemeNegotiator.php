<?php
/**
 * @file
 * Contains \Drupal\bobpol_user\Theme\BobpolUserThemeNegotiator.
 */
namespace Drupal\bobpol_user\Theme;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;
/**
 * Class ThemeNegotiator
 *
 * Controls which theme is applies to a given path.
 *
 * @package Drupal\bobpol_user\Theme
 */
class BobpolUserThemeNegotiator implements ThemeNegotiatorInterface {
  /**
   * Renegotiate paths from administration theme to bobpol theme.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $route
   * @return bool
   */
  public function applies(RouteMatchInterface $route) {
    switch ($route->getRouteName()) {
      case 'entity.user.edit_form':
        return true;
      case 'entity.user.cancel_form':
        return true;
    }
    return false;
  }
  /**
   * {@inheritdoc}
   */
  public function determineActiveTheme(RouteMatchInterface $route) {
     return 'bobpol';
  }
}