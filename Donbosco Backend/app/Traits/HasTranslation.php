<?php

namespace App\Traits;

trait HasTranslation
{
    public function translateField($model, $fieldName)
    {
        $currentLocale = app()->getLocale();
        $rawValue = $model->getRawOriginal($fieldName);
        $decoded = json_decode($rawValue, true);

        if (is_array($decoded)) {
            if (isset($decoded[$currentLocale])) {
                return $decoded[$currentLocale];
            }
            
            return reset($decoded);
        }

        return $rawValue;
    }
}
