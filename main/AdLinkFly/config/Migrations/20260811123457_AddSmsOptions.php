<?php
use Migrations\AbstractMigration;

class AddSmsOptions extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('options');
        
        $data = [
            [
                'name' => 'sms_verification_enabled',
                'value' => 'no',
            ],
            [
                'name' => 'sms_revesms_api_key',
                'value' => '',
            ],
            [
                'name' => 'sms_revesms_secret_key',
                'value' => '',
            ],
            [
                'name' => 'sms_revesms_caller_id',
                'value' => '',
            ]
        ];

        // Check if options already exist to prevent duplicates
        $builder = $this->getQueryBuilder();
        $builder->select(['name'])->from('options')->where(['name' => 'sms_verification_enabled']);
        $stmt = $builder->execute();
        $exists = $stmt->fetch();

        if (!$exists) {
            $table->insert($data)->save();
        }
    }

    public function down()
    {
        $this->execute("DELETE FROM options WHERE name IN ('sms_verification_enabled', 'sms_revesms_api_key', 'sms_revesms_secret_key', 'sms_revesms_caller_id')");
    }
}
