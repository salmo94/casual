<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\db\Query;


class BaseModel extends ActiveRecord
{

    public const STATUS_ACTIVE = 1;
    public const STATUS_HIDDEN = 2;
    public const STATUS_TITLES = [
        self::STATUS_ACTIVE => 'Активний',
        self::STATUS_HIDDEN => 'Прихований'
    ];

    /**
     * @param Query $query
     * @param string $dateString
     * @param string $dateColumn
     * @return void
     */
    public function dateFilter(Query $query,string $dateString,string $dateColumn): void
    {
        if (!empty($dateString)) {
            $date = explode('--', $dateString);
            $fromDate = $date[0] ?? null;
            $toDate = $date[1] ?? null;
            if ($fromDate !== null && $toDate !== null) {
                $query->andWhere(['between', $dateColumn, $fromDate, $toDate]);
            }
        }
    }
}
