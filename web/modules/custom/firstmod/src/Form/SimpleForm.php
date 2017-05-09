<?php

namespace Drupal\firstmod\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form;
use Drupal\Core\Form\FormStateInterface;

class SimpleForm extends FormBase {
	public function getFormId() {
		return 'simple_form';
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
		$form ['name'] = array (
				'#title' => t ( 'Your full name' ),
				'#type' => 'textfield',
				'#required' => TRUE
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
		if (strlen ( $form_state->getvalue ( 'name' ) ) < 5) {
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
		drupal_set_message ( 'form-submitted' );
	}
}