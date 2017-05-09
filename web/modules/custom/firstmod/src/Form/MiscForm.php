<?php

namespace Drupal\firstmod\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\State\StateInterface;

/**
 * Class MiscForm.
 *
 * @package Drupal\firstmod\Form
 */
class MiscForm extends FormBase {
	private $state;
	public function __construct(StateInterface $state) {
		$this->state = $state;
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function getFormId() {
		return 'misc_form';
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {
		$form ['qualification'] = [
				'#type' => 'select',
				'#title' => $this->t ( 'Qualification' ),
				'#options' => array (
						'U.G' => $this->t ( 'U.G' ),
						'P.G' => $this->t ( 'P.G' ),
						'others' => $this->t ( 'others' )
				),
				'#size' => 3
		];
		$form ['other_qualification'] = [
				'#type' => 'textfield',
				'#title' => $this->t ( 'Other Qualification' ),
				'#states' => array (
						'visible' => array (
								':input[name="qualification"]' => array (
										'value' => 'others'
								)
						)
				)
		];
		$form ['Country'] = [
				'#type' => 'select',
				'#title' => $this->t ( 'Select Country' ),
				'#options' => array (
						'India' => $this->t ( 'India' ),
						'UK' => $this->t ( 'UK' )
				),
				'#ajax' => [
						'callback' => 'Druapl\firstmod\Form\MiscForm::populateStates',
						'wrapper' => 'ajax-callback-wrapper'
				]
		];
		$form ['ajax-container'] = [
				'#type' => 'container',
				'#attributes' => [
						'id' => 'ajax-callback-wrapper'
				]
		];

		$form ['submit'] = [
				'#type' => 'submit',
				'#value' => $this->t ( 'Submit' )
		];

		return $form;
	}
	public function populateStates(array &$form, FormStatesInterface $form_state) {
		$country = $form_state->getValue ( 'Country' );
		$states ['India'] = [
				'MH',
				'TN',
				'MP'
		];
		$states ['UK'] = [
				'London',
				'Barcelona',
				'Spain'
		];
		$form ['ajax-container'] ['states'] = [
				'#type' => 'select',
				'#options' => $states [$country]
		];

		return $form ['ajax-container'];
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {
		parent::validateForm ( $form, $form_state );
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		// Display result.
		foreach ( $form_state->getValues () as $key => $value ) {
			drupal_set_message ( $key . ': ' . $value );
		}
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( 'state' ) );
	}
}
