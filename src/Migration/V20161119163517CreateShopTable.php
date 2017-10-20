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
            ->string('out_id', 32)->comment('外部系统编号,可用于数据关联,同步等')
            ->int('wechatLocationId')->comment('微信门店编号 0未导入 -1导入失败')
            ->bigInt('wechat_poi_id')
            ->string('source_code', 32)->comment('来源的标识')
            ->string('name')
            ->string('branchName', 32)->comment('分店名')
            ->text('photo_list')
            ->string('categories')->comment('门店分类')
            ->string('province', 64)
            ->string('city', 64)
            ->string('address')
            ->tinyInt('offset_type', 1)->comment('坐标类型')
            ->string('lat', 64)
            ->string('lng', 64)
            ->string('phone', 32)
            ->string('recommend')
            ->string('special')
            ->string('introduction', 300)
            ->string('open_time', 16)
            ->smallInt('avg_price')
            ->text('linkTo')
            ->tinyInt('available_state')
            ->string('result_message', 64)->comment('审核结果的信息')
            ->tinyInt('update_status')
            ->timestamps()
            ->userstamps()
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
