<?php

namespace backend\helpers;

use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use yii\base\BaseObject;
use yii\helpers\Url;
use yii\web\JsExpression;

class WidgetsHelper
{
    /**
     * @param BaseObject $searchModel
     * @param string $attribute
     * @param string $ValueText
     * @param string $path
     * @return string
     * @throws \Throwable
     */
    public static function getSelect2(BaseObject $searchModel, string $attribute, string $ValueText, string $path): string
    {
        return Select2::widget([
            'model' => $searchModel,
            'attribute' => $attribute,
            'initValueText' => $ValueText,
            'language' => 'uk-UK',
            'options' => ['placeholder' => 'Натисніть щоб вибрати...'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 2,
                'ajax' => [
                    'url' => Url::to([$path]),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
            ],
        ]);
    }

    /**
     * @param BaseObject $searchModel
     * @param string $attribute
     * @return string
     * @throws \Throwable
     */
    public static function getDateRangePicker(BaseObject $searchModel, string $attribute): string
    {
        return DateRangePicker::widget([
              'language' => 'uk-UK',
              'model' => $searchModel,
              'attribute' => $attribute,
              'convertFormat' => true,
              'pluginOptions' => ['allowClear' => true,
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
              ]
          ]);
    }
}
