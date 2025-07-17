<?php

namespace Drupal\example_custom_access\EventSubscriber;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Alters specific routes at runtime.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * Removes 'editor' role from the route's _role requirement.
   *
   * @param \Symfony\Component\Routing\RouteCollection $collection
   *   The route collection to modify.
   */
  protected function alterRoutes(RouteCollection $collection): void {
    if ($route = $collection->get('example_custom_access.page')) {
      if ($route->hasRequirement('_role')) {
        $roles = explode('+', $route->getRequirement('_role'));
        $roles = array_diff($roles, ['editor']);
        $route->setRequirement('_role', implode('+', $roles));
      }
    }
  }

}
