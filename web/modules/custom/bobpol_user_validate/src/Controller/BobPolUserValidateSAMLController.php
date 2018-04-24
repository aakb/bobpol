<?php

namespace Drupal\bobpol_user_validate\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\samlauth\SamlService;
use Drupal\samlauth\SamlUserService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * KobaBookingApiController.
 */
class BobPolUserValidateSAMLController extends ControllerBase {

  /**
   * @var \OneLogin_Saml2_Auth
   */
  protected $auth;

  /**
   * @var Drupal\samlauth\SamlService
   */
  protected $saml;

  /**
   * @var Drupal\samlauth\SamlUserService
   */
  protected $saml_user;

  /**
   * Constructor for BobPolUserValidateSAMLController.
   *
   * @param \Drupal\samlauth\Controller\SamlService $samlauth_saml
   */
  public function __construct(SamlService $saml, SamlUserService $saml_user, \OneLogin_Saml2_Auth $auth) {
    $this->saml = $saml;
    $this->saml_user = $saml_user;
    $this->auth = $auth;
  }

  /**
   * Factory method for dependency injection container.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @return static
   */
  public static function create(ContainerInterface $container) {
    $config = samlauth_get_config();
    $auth = new \OneLogin_Saml2_Auth($config);

    return new static(
      $container->get('samlauth.saml'),
      $container->get('samlauth.saml_user'),
      $auth
    );
  }

  /**
   * Save current path and redirect to SAML login.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   */
  public function login(Request $request) {
    // Set newest booking information.
    $data = array(
      'url' => $current_path = \Drupal::service('path.current')->getPath(),
      'expire' => \Drupal::time()->getRequestTime() + 300,
    );

    // Store information in session.
    \Drupal::service('session')->set('bobpol_user_validate', $data);

    return $this->redirect('samlauth.saml_controller_login');
  }

  /**
   * Login to nemid via SAML.
   *
   * Redirects to SAML logout that redirect to add booking.
   */
  public function acs() {
    $errors = $this->saml->acs();
    if (!empty($errors)) {
      $messenger = \Drupal::messenger();
      $messenger->addError($this->t('An error occured during login.'));
      return $this->redirect('samlauth.saml_controller_sls');
    }

    try {
      $saml_data = $this->saml->getData();

      // The mail attribute changes its status from MUST into MAY as of May 2013 - WAYF.
      if (!empty($saml_data['mail'])) {
        $data['mail'] = $saml_data['mail'];
      }

      // Get name.
      $data['name'] = $saml_data['eduPersonTargetedID'];

      // Get unique wayf ID.
      //$data['uuid'] = $saml_data['urn:oid:1.3.6.1.4.1.5923.1.1.1.10'];

      \Drupal::service('session')->set('koba_booking_request', $data);

    }
    catch (\Exception $e) {
      $messenger = \Drupal::messenger();
      $messenger->addError($e->getMessage());
      return $this->redirect('samlauth.saml_controller_sls');
    }

    // We need to log the user out of SAML login. But as this is not supported
    // by the ADFS (or not working). We use an iframe on the add booking page
    // that do the logout - HACK.
    $data = \Drupal::service('session')->get('bobpol_user_validate');
    $url = empty($data['url']) ? \Drupal\Core\Url::fromRoute('<front>')->toString() : $data['url'];
    return $this->redirect($url);
  }
}
