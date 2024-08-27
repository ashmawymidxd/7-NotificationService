<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateNotificationsTable extends AbstractMigration
{
   
    public function change(): void
    {
        $table = $this->table('notifications');
        $table->addColumn('user_id', 'integer')
                ->addColumn('message', 'string')
                ->addColumn('type', 'string', ['limit' => 50], ['null' => true], ['default' => 'info'])
                ->addColumn('created_at', 'datetime')
                ->addColumn('updated_at', 'datetime')
              ->create();

    }
}
