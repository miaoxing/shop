<?php

namespace Miaoxing\Shop\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20161119164252CreateShopUsersTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('shopUsers')
            ->id()
            ->int('appId')
            ->int('shopId')
            ->int('userId')
            ->text('linkTo')
            ->timestamps()
            ->int('createUser')
            ->int('updateUser')
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->dropIfExists('shopUsers');
    }
}
