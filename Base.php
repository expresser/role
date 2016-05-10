<?php namespace Expresser\Role;

use WP_Role;

abstract class Base extends \Expresser\Support\Model {

  protected $role;

  public function __construct(WP_Role $role = null) {

    $this->role = $role ?: new WP_Role($this->name, $this->capabilities);

    parent::__construct((array)$this->role);
  }

  public function addCapability($capability) {

    $this->role->add_cap($capability);
  }

  public function capabilities() {

    return [];
  }

  public function newQuery() {

    return (new Query)->setModel($this)->name($this->name);
  }

  public function removeCapability($capability) {

    $this->role->remove_cap($capability);
  }

  public static function registerHooks($class) {

    add_action('after_switch_theme', [$class, 'registerRole'], PHP_INT_MAX);
    add_action('after_switch_theme', [$class, 'registerCapabilities'], PHP_INT_MAX);
    add_action('switch_theme', [$class, 'deregisterCapabilities'], PHP_INT_MAX);
    add_action('switch_theme', [$class, 'deregisterRole'], PHP_INT_MAX);
  }

  public static function registerRole() {

    $role = new static;

    add_role($role->name, $role->label);
  }

  public static function registerCapabilities() {

    $role = new static;

    foreach ($role->capabilities as $capability) {

      $role->addCapability($capability);
    }
  }

  public static function deregisterRole() {

    $role = new static;

    remove_role($role->name);
  }

  public static function deregisterCapabilities() {

    $role = new static;

    foreach ($role->capabilities as $capability) {

      $role->removeCapability($capability);
    }
  }

  public abstract function label();

  public abstract function name();
}
