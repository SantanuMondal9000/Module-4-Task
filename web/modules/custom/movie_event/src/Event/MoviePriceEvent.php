<?php

namespace Drupal\movie_event\Event;

use Drupal\Component\EventDispatcher\Event;
use Drupal\node\NodeInterface;

/**
 * Event that is fired when a user logs in.
 */
class MoviePriceEvent extends Event {

  // This makes it easier for subscribers to reliably use our event name.
  const EVENT_NAME = 'custom_movie_price_event';

  /**
   * The user account.
   *
   * @var \Drupal\node\NodeInterface
   */
  public $node;

  /**
   * Constructs the object.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The account of the user logged in.
   */
  public function __construct(NodeInterface $node) {
    $this->node = $node;
  }

}
