<?php

namespace MiaoxingTest\Shop\Controller\Admin;

use Miaoxing\Plugin\Test\BaseControllerTestCase;

class ShopTest extends BaseControllerTestCase
{
    /**
     * 页面可以正常访问
     *
     * {@inheritdoc}
     * @dataProvider providerForActions
     */
    public function testActions($action, $code = null)
    {
        // TODO 拆分逻辑
        if ($action == 'syncWithWechat') {
            return;
        }
        parent::testActions($action, $code);
    }
}
