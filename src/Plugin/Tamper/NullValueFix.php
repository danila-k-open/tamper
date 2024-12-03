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
 *   id = "null_value_fix",
 *   label = @Translation("Null Value Fix"),
 *   description = @Translation("This plugin adds the ability to fix null value"),
 *   category = "Text"
 * )
 */
class NullValueFix extends TamperBase {

    const SETTING_NUll_VALUE = 'null_value';
    const SETTING_FIX_VALUE = 'fix_value';

    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration() {
        $config = parent::defaultConfiguration();
        $config[self::SETTING_NUll_VALUE] = '#ÇÍÀ×!';
        $config[self::SETTING_FIX_VALUE] = '';
        return $config;
    }

    /**
     * {@inheritdoc}
     */
    public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
        $form[self::SETTING_NUll_VALUE] = [
            '#type' => 'textfield',
            '#title' => $this->t('Enter null value'),
            '#default_value' => $this->getSetting(self::SETTING_NUll_VALUE),
            '#description' => $this->t('Enter a null value'),
        ];
        $form[self::SETTING_FIX_VALUE] = [
            '#type' => 'textfield',
            '#title' => $this->t('Enter null value'),
            '#default_value' => $this->getSetting(self::SETTING_FIX_VALUE),
            '#description' => $this->t('Enter a fix value'),
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
        parent::submitConfigurationForm($form, $form_state);
        $this->setConfiguration([self::SETTING_NUll_VALUE => $form_state->getValue(self::SETTING_NUll_VALUE)]);
        $this->setConfiguration([self::SETTING_FIX_VALUE => $form_state->getValue(self::SETTING_FIX_VALUE)]);
    }

    /**
     * {@inheritdoc}
     */
    public function tamper($data, TamperableItemInterface $item = NULL) {
        $null_val = $this->getSetting(self::SETTING_NUll_VALUE);
        $fix_val = $this->getSetting(self::SETTING_FIX_VALUE);
        if(empty($data)){
            $return = $fix_val;
        }elseif ($data == $null_val){
            $return = $fix_val;
        }else{
            $return = $data;
        }
        return $return;
    }

}