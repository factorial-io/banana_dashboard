<?php

namespace Drupal\banana_dashboard;

use Drupal\Component\Plugin\Exception\PluginException;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Plugin\Discovery\ContainerDerivativeDiscoveryDecorator;
use Drupal\Core\Plugin\Discovery\YamlDiscovery;

/**
 * Provides the default banana_dashboard manager.
 */
class BananaDashboardManager extends DefaultPluginManager implements BananaDashboardManagerInterface {

  /**
   * Provides default values for all banana_dashboard plugins.
   *
   * @var array
   */
  protected $defaults = [
    // Add required and optional plugin properties.
    //'id' => '',
    //'label' => '',
     // 'url' => '',
     // 'title' => '',
    //  'access arguments' => '',
    //  'dashboard_menu_groups' => [],
     // 'dashboard_menu'=>[],
  ];

  /**
   * Constructs a new BananaDashboardManager object.
   *
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   */
  public function __construct(ModuleHandlerInterface $module_handler, CacheBackendInterface $cache_backend) {
    // Add more services as required.
    $this->moduleHandler = $module_handler;
    $this->setCacheBackend($cache_backend, 'banana_dashboard', ['banana_dashboard']);
  }

  /**
   * {@inheritdoc}
   */
  protected function getDiscovery() {
    if (!isset($this->discovery)) {
      $this->discovery = new YamlDiscovery('banana_dashboard', $this->moduleHandler->getModuleDirectories());
      $this->discovery->addTranslatableProperty('title', 'title_context');
      $this->discovery = new ContainerDerivativeDiscoveryDecorator($this->discovery);
    }
    return $this->discovery;
  }

  /**
   * {@inheritdoc}
   */
  public function processDefinition(&$definition, $plugin_id) {
    parent::processDefinition($definition, $plugin_id);
    unset($definition['id']);
    unset($definition['provider']);

    // You can add validation of the plugin definition here.
    if (empty($definition['id'])) {
      //throw new PluginException(sprintf('Example plugin property (%s) definition "is" is required.', $plugin_id));
    }
  }

  // Add other methods here as defined in the BananaDashboardManagerInterface.

}