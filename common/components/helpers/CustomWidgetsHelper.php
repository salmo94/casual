<?php

namespace common\components\helpers;

use yii\helpers\Url;
use yii\web\JsExpression;

class CustomWidgetsHelper
{
    /**
     * @return array
     */
    public static function getSelect2PluginOptions(): array
    {
        return [
            'allowClear' => true,
            'minimumInputLength' => 2,
            'ajax' => [
                'url' => Url::to(['category/autocomplete']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
        ];
    }

    /**
     * @return array
     */
    public static function getDateRangePickerPluginOptions(): array
    {
        return [
            'allowClear' => true,
            'showDropdowns' => true,
            'timePicker' => true,
            'timePicker24Hour' => true,
            'timePickerIncrement' => 1,
            'locale' => [
                'format' => 'Y-m-d H:i:00',
                'separator' => '--',
                'applyLabel' => 'Підтвердити',
                'cancelLabel' => 'Відміна',
            ],
            'opens' => 'right',
        ];
    }
}
