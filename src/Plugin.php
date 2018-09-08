<?php

namespace Miaoxing\Shop;

class Plugin extends \Miaoxing\Plugin\BasePlugin
{
    protected $name = '门店管理';

    protected $description = '';

    protected $adminNavId = 'settings';

    public function onAdminNavGetNavs(&$navs, &$categories, &$subCategories)
    {
        $navs[] = [
            'parentId' => 'settings',
            'url' => 'admin/shop/index',
            'name' => wei()->shop->shopName . '管理',
        ];
    }

    public function onLinkToGetLinks(&$links, &$types)
    {
        $links[] = [
            'typeId' => 'site',
            'name' => wei()->shop->shopName . '导航',
            'url' => 'shop/index',
        ];
    }
}
