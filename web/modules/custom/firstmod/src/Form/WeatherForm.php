<?php

namespace Drupal\firstmod\Form;

use Drupal\Core\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
// use Drupal\test\DbWrapper;
// use Symfony\Component\DependencyInjection\ContainerInterface;
class WeatherForm extends ConfigFormBase {

	/**
	 * Returns a unique string identifying the form.
	 *
	 * @return string The unique string identifying the form.
	 */
	/*
	 * private $dbwrapper;
	 * public function __construct(DbWrapper $dbwrapper) {
	 * $this->dbwrapper = $dbwrapper;
	 * }
	 */ 
public function getFormId() {
		return 'weather_config_form';
	}

	/**
	 * Form constructor.
	 *
	 * @param array $form
	 *        	An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *        	The current state of the form.
	 *
	 * @return array The form structure.
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {
		// $fetched = $this->dbwrapper->getData ();
		$form ['appid'] = [
				'#type' => 'textfield',
				'#title' => 'Weather app API key',
				'#default_value' => $this->config('firstmod.weather_config')->get('appid')
				
				
		];

		return parent::buildForm ($form, $form_state);
	} 
	protected function getEditableConfigNames() {
		return [
			'firstmod.weather_config'
		];
	}
	
	public function validateForm(array &$form, FormStateInterface $form_state) {
		parent::validateForm ( $form, $form_state );
	}
	
/** 
/**
	 * Form validation handler.
	 *
	 * @param array $form
	 *        	An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *        	The current state of the form.
	 */

	/**
	 * Form submission handler.
	 *
	 * @param array $form
	 *        	An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *        	The current state of the form.
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		$this->config('firstmod.weather_config')->set('appid',$form_state->getValue('appid'))->save();
		parent::submitForm ($form, $form_state);
		// drupal_set_message ( 'Form sent' );;
		// $this->dbwrapper->setData ( $form_state->getValue ( 'fname' ), $form_state->getValue ( 'lname' ) );
	}
	/*
	 * public static function create(ContainerInterface $container) {
	 * return new static ( $container->get ( 'test.dbwrapper' ) );
	 * }
	 */
} 
