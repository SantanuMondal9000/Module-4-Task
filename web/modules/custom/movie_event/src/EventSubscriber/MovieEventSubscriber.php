<?php

namespace Drupal\movie_event\EventSubscriber;

use Drupal\movie_event\Event\MoviePriceEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class UserLoginSubscriber will make a logic to deside the budget statement.
 */
class MovieEventSubscriber implements EventSubscriberInterface {

  /**
   * This will store the messanger object for display the message.
   *
   * @var Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Used to load the 'movie_budget.settings' configuration.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a MovieEventSubscriber object.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service for displaying status messages to the user.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service used to load and read configuration values.
   */
  public function __construct(MessengerInterface $messenger, ConfigFactoryInterface $config_factory) {
    $this->messenger = $messenger;
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      // Static class constant => method on this class.
      MoviePriceEvent::EVENT_NAME => 'onNodeView',
    ];
  }

  /**
   * Subscribe to the user login event dispatched.
   *
   * @param \Drupal\movie_event\Event\MoviePriceEvent $event
   *   Our custom event object.
   */
  public function onNodeView(MoviePriceEvent $event) {
    $node = $event->node;
    $config = $this->configFactory->get;('movie_budget.settings');
    $budget_amount = $config->get('budget');

    if ($node->hasField('field_movie_price')) {
      $price = $node->get('field_movie_price')->value;

      if ($price < $budget_amount) {
        $this->messenger->addStatus($this->t('This movie is over budget!'), $repeat = TRUE);
      }
      elseif ($price > $budget_amount) {
        $this->messenger->addStatus($this->t('This movie is over budget!'), $repeat = TRUE);
      }
      else {
        $this->messenger->addStatus($this->t('This movie is within budget!'), $repeat = TRUE);
      }

    }

  }

}
