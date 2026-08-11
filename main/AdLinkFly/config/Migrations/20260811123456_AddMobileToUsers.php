<?php
use Migrations\AbstractMigration;

class AddMobileToUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('users');
        if (!$table->hasColumn('mobile')) {
            $table->addColumn('mobile', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ]);
        }
        if (!$table->hasColumn('mobile_verified_at')) {
            $table->addColumn('mobile_verified_at', 'datetime', [
                'default' => null,
                'null' => true,
            ]);
        }
        if (!$table->hasColumn('sms_code')) {
            $table->addColumn('sms_code', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ]);
        }
        $table->update();
    }
}
