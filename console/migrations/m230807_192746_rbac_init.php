<?php

use yii\db\Migration;

/**
 * Class m230807_192746_rbac_init
 */
class m230807_192746_rbac_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $filePath = __DIR__ . '/schema-pgsql.sql';

        if (!file_exists($filePath)) {
            throw new Exception('Файла дампа не обнаружено');
        }
        $fileContent = file_get_contents($filePath);
        $commands = explode(";\n", $fileContent);

        foreach ($commands as $command) {
            $this->execute($command);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230807_192746_rbac_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230807_192746_rbac_init cannot be reverted.\n";

        return false;
    }
    */
}
