<?php

namespace Drupal\firstmod\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use symfony\Component\HttpKernel\KernelEvents;
use symfony\Component\HttpKernel\Event\FilterResponseEvent;

class AccessHeaderInjector implements EventSubscriberInterface {
	public static function getSubscribedEvents() {
		return [
				KernelEvents::RESPONSE => [
						'addAccessHeader'
				]
		];
	}
	public function addAccessHeader(FilterResponseEvent $event) {
		$response = $event->getResponse ();
		$response->headers->add ( [
				'access-control-allow-origin' => '*'
		] );
	}
}