<?php

namespace Drupal\firstmod\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\firstmod\DbWrapper;

class DicForm extends FormBase {
	private $dbwrapper;
	public function __construct(DbWrapper $dbwrapper) {
		$this->dbwrapper = $dbwrapper;
	}
	public function getFormId() {
		return 'Dic_form';
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
		$fetched = $this->dbwrapper->getData ();
		$form ['fname'] = array (
				'#title' => t ( 'Firstname' ),
				'#type' => 'textfield',
				'#required' => TRUE,
				'#default_value' => $fetched ['fname']
		);
		$form ['lname'] = array (
				'#title' => t ( 'Lastname' ),
				'#type' => 'textfield',
				'#required' => TRUE,
				'#default_value' => $fetched ['lname']
		);

		// Provide a submit button.
		$form ['submit'] = array (
				'#type' => 'submit',
				'#value' => 'Submit'
		);

		return $form;
	}
	/**
	 * Form validation handler.
	 *
	 * @param array $form
	 *        	An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *        	The current state of the form.
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {
		if (strlen ( $form_state->getvalue ( 'fname' ) ) < 5) {
			$form_state->setErrorByName ( 'name', $this->t ( 'Name is to short.' ) );
		}
	}

	/**
	 * Form submission handler.
	 *
	 * @param array $form
	 *        	An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *        	The current state of the form.
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		// drupal_set_message ( 'Form sent' );;
		$this->dbwrapper->setData ( $form_state->getValue ( 'fname' ), $form_state->getValue ( 'lname' ) );
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( 'firstmod.dbwrapper' ) );
	}
}