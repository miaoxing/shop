<?php

namespace Miaoxing\Shop;

class Plugin extends \miaoxing\plugin\BasePlugin
{
    protected $name = '门店管理';

    protected $description = '';

    protected $adminNavId = 'settings';

    public function onAdminNavGetNavs(&$navs, &$categories, &$subCategories)
    {
        $navs[] = [
            'parentId' => 'settings',
            'url' => 'admin/shop/index',
            'name' => '门店管理',
        ];
    }

    public function onLinkToGetLinks(&$links, &$types)
    {
        $links[] = [
            'typeId' => 'site',
            'name' => '门店导航',
            'url' => 'shop/index'
        ];
    }
}
