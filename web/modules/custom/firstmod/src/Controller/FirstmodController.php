<?php

namespace Drupal\firstmod\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\node\NodeInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxy;

class FirstmodController implements ContainerInjectionInterface {
	public function __construct(AccountProxy $account) {
		$this->account = $account;
	}
	public function content() {
		return [
				'#markup' => "Hello!"
		];
	}
	public function dcontent($arg) {
		return [
				'#markup' => "Hello!" . $arg
		];
	}
	public function upcastecontent(NodeInterface $node) {
		return [
				'#markup' => "Hello!" . $node->getTitle ()
		];
	}
	public function nodeCreatorCheck(NodeInterface $node) {
		$account = \Drupal::service ( 'current_user' );
		if ($node->getOwnerID () === $account->id ()) {
			return AccessResult::allowed ();
		} else {
			return AccessResult::forbidden ();
		}
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( 'current_user' ) );
	}
}