<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $table = $this->table('users');

        $table->addColumn('name', 'string', ['null' => false, 'limit' => 255])
        ->addColumn('email', 'string', ['null' => false, 'limit' => 255])
        ->addColumn('password', 'string', ['null' => false, 'limit' => 255])
        ->addIndex(['email'], ['unique' => true])
        ->addTimestamps(null, 'email_verified_at', true)
        ->create();
    }

    public function down()
    {
        $tableExists = $this->hasTable('users');

        if($tableExists) {
            $this->table('users')->drop()->save();
        }
        else {
            throw new \Exception("Table not found.");
        }
    }
}
