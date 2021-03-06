<?php

namespace Drupal\firstmod\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\firstmod\OpenWeatherManager;

/**
 * @Block(
 * id="weather_block",
 * admin_label="weather Block"
 * )
 */
class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface {
	public function __construct(array $configuration, $plugin_id, $plugin_definition, OpenWeatherManager $manager) {
		parent::__construct ( $configuration, $plugin_id, $plugin_definition );
		$this->manager = $manager;
	}
	public function build() {
		$weather_data = $this->manager->pullData ( $this->configuration ['city_name'] );
		return [
				'#theme' => 'weather_widget',
				'#weather_data' => $weather_data,
				'#attached' => [
						'library' => [
								'test/weather_widget'
						]
				]
		];
	}
	public function blockForm($form, FormStateInterface $form_state) {
		$form ['city_name'] = [
				'#type' => 'textfield',
				'#title' => 'City Name',
				'#default_value' => $this->configuration ['city_name']
		];
		return $form;
	}
	public function blockSubmit($form, FormStateInterface $form_state) {
		$this->configuration ['city_name'] = $form_state->getValue ( 'city_name' );
	}
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
		return new static ( $configuration, $plugin_id, $plugin_definition, $container->get ( 'firstmod.openweather' ) );
	}
}