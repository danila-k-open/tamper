<?php

namespace Drupal\tamper\Plugin\Tamper;

use Drupal\tamper\TamperableItemInterface;
use Drupal\tamper\TamperBase;
use Drupal\tamper\Exception\TamperException;
use Drupal\Core\Form\FormStateInterface;
/**
 * Plugin implementation for casting to integer.
 *
 * @Tamper(
 *   id = "set_unique_id",
 *   label = @Translation("Set Unique ID"),
 *   description = @Translation("This plugin adds the ability to convert the value to unique"),
 *   category = "Text"
 * )
 */
class SetUniqID extends TamperBase {

    const SETTING_PREFIX = 'set_unicue_id';
    const SETTING_UNIQUE = 'set_unicue';

    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration() {
        $config = parent::defaultConfiguration();
        $config[self::SETTING_PREFIX] = 'article';
        $config[self::SETTING_UNIQUE] = '1';
        return $config;
    }

    /**
     * {@inheritdoc}
     */
    public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
        $form[self::SETTING_PREFIX] = [
            '#type' => 'textfield',
            '#title' => $this->t('Enter prefix'),
            '#default_value' => $this->getSetting(self::SETTING_PREFIX),
            '#description' => $this->t('Enter a prefix for the value'),
        ];
        $form[self::SETTING_UNIQUE] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Use current value'),
            '#default_value' => $this->getSetting(self::SETTING_UNIQUE),
            '#description' => $this->t('Select all digits from the value and add the prefix to it'),
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
        parent::submitConfigurationForm($form, $form_state);
        $this->setConfiguration([self::SETTING_PREFIX => $form_state->getValue(self::SETTING_PREFIX)]);
        $this->setConfiguration([self::SETTING_UNIQUE => $form_state->getValue(self::SETTING_UNIQUE)]);
    }

    /**
     * {@inheritdoc}
     */
    public function tamper($data, TamperableItemInterface $item = NULL) {
        $prefix = $this->getSetting(self::SETTING_PREFIX);
        $unique = $this->getSetting(self::SETTING_UNIQUE);
        if($unique == '1'){
            preg_match_all('/\d+/', $data, $matches);
            $all_numbers = $matches[0];
            $all_numbers_string = implode('', $all_numbers);
            $return = $prefix.'_'.$all_numbers_string;
        }else{
            $unique_id = uniqid();
            $return = $prefix.'_'.$unique_id;
        }
        return $return;
    }

}