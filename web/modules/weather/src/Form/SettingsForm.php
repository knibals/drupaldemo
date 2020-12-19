<?php

namespace Drupal\weather\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Weather settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'weather_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['weather.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['city'] = [
      '#type' => 'textfield',
      '#size' => 20,
      '#maxlength' => 120,
      '#required' => true,
      '#title' => $this->t('City'),
      '#default_value' => $this->config('weather.settings')->get('city'),
    ];
    $form['country_code'] = [
      '#size' => 3,
      '#maxlength' => 3,
      '#type' => 'textfield',
      '#title' => $this->t('Country code'),
      '#default_value' => $this->config('weather.settings')->get('country_code'),
    ];
      '#type' => 'textfield',
      '#title' => $this->t('Example'),
      '#default_value' => $this->config('weather.settings')->get('example'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!ctype_alnum($form_state->getValue('city'))) {
      $form_state->setErrorByName('city', $this->t('The city name looks incorrect.'));
    }
    if (!empty($form_state->getValue('country_code'))) {
      if (!ctype_alpha($form_state->getValue('country_code'))) {
        $form_state->setErrorByName('country_code', $this->t('The country code should only have letters!'));
      }
    }
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('weather.settings')
      ->set('city', $form_state->getValue('city'))
      ->set('country_code', $form_state->getValue('country_code'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
