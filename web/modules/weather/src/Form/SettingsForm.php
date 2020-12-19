<?php

namespace Drupal\weather\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;

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
    $form['api'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('API informations'),
      '#description' => t('the informations are provided by OpenWeatherMap'),
      '#attributes' => [
        'class' => [
          'container-inline',
        ],
      ],
    ];
    $form['api']['key'] = [
      '#type' => 'textfield',
      '#size' => 32,
      '#maxlength' => 32,
      '#required' => true,
      '#title' => $this->t('Secret Key'),
      '#default_value' => $this->config('weather.settings')->get('api.key'),
    ];
    $form['api']['endpoint'] = [
      '#size' => 40,
      '#maxlength' => 255,
      '#required' => true,
      '#type' => 'textfield',
      '#title' => $this->t('Endpoint'),
      '#default_value' => $this->config('weather.settings')->get('api.endpoint'),
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
    if (!ctype_alnum($form_state->getValue('key'))) {
      $form_state->setErrorByName('key', $this->t('Please double-check the API key.'));
    }
    /**
     * todo: the 'isValid' method of the Drupal 'UrlHelper' class is weak
     */
    if (!UrlHelper::isValid($form_state->getValue('endpoint'))) {
      $form_state->setErrorByName('endpoint', $this->t('Humm... this doesn\'t look and real URL.'));
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
      ->set('api.key', $form_state->getValue('key'))
      ->set('api.endpoint', $form_state->getValue('endpoint'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
