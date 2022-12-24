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
        $this->table('users')
        ->addColumn('name', 'string', ['null' => false, 'limit' => 255])
        ->addColumn('email', 'string', ['null' => false, 'limit' => 255])
        ->addColumn('password', 'string', ['null' => false, 'limit' => 255])
        ->addColumn('profile_pic', 'string', ['null' => true, 'limit' => 2048])
        ->addTimestamps()
        ->addColumn('deleted_at', 'timestamp', ['null' => true])
        ->addIndex(['email'], ['unique' => true])
        ->create();
    }

    public function down()
    {
        $tableExists = $this->hasTable('users');

        if($tableExists) {
            $this->table('users')->drop()->save();
        }
    }
}
