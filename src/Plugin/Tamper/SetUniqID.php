<?php

namespace Drupal\tamper\Plugin\Tamper;

use Drupal\tamper\TamperableItemInterface;
use Drupal\tamper\TamperBase;

/**
 * Plugin implementation for casting to integer.
 *
 * @Tamper(
 *   id = "set_unique_id",
 *   label = @Translation("Set unique ID"),
 *   description = @Translation("This plugin will set value to unique ID."),
 *   category = "Text"
 * )
 */
class SetUniqID extends TamperBase {

    /**
     * {@inheritdoc}
     */
    public function tamper($data, TamperableItemInterface $item = NULL) {
        preg_match_all('/\d+/', $data, $matches);
        $all_numbers = $matches[0];
        $all_numbers_string = implode('', $all_numbers);
        return 'article_'.$all_numbers_string;
    }

}
