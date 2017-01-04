<?php

namespace Miaoxing\Shop\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20161119163517CreateShopTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('shop')
            ->id()
            ->int('wechatLocationId')->comment('微信门店编号 0未导入 -1导入失败')
            ->string('name')
            ->string('branchName', 32)->comment('分店名')
            ->string('image')
            ->string('category', 16)->comment('门店分类')
            ->string('province', 64)
            ->string('city', 64)
            ->string('address')
            ->string('lat', 64)
            ->string('lng', 64)
            ->string('phone', 32)
            ->text('linkTo')
            ->timestamps()
            ->bool('enable')
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->dropIfExists('shop');
    }
}
