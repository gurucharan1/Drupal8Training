<?php

namespace Drupal\firstmod;

use Drupal\Core\Config\ConfigFactory;
use Guzzlehttp\Client;
use Drupal\Component\Serialization\Json;

class OpenWeatherManager {
	private $client, $config;
	public function __construct(ConfigFactory $config, Client $client) {
		$this->config = $config;
		$this->client = $client;
	}
	public function dummy() {
		kint ( $this->client );
		kint ( $this->config );
	}
	public function getGuzzle() {
		$res = $this->client->request ( 'GET', 'http://api.openweathermap.org/data/2.5/weather?q=London,uk&APPID=2ae6e13f8875b87d47454e897e6da198' );
		return $res;
	}
	public function pullData($cityname) {
		$appID = $this->config->get ( 'firstmod.weather_config' )->get ( 'appid' );
		// kint ( $appID );
		$res = $this->client->request ( 'GET', 'http://api.openweathermap.org/data/2.5/weather', [
				'query' => [
						'q' => $cityname,
						'appid' => $appID
				]
		] );
		// return $res->getBody ()->getContents ();
		return Json::decode ( $res->getBody ()->getContents () );
	}
}