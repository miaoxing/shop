<?php

namespace MiaoxingTest\Shop\Service;

class ShopTest extends \Miaoxing\Plugin\Test\BaseTestCase
{
    public function testShop()
    {
        $this->assertTrue(true);
    }

    public function providerForSync()
    {
        return [
            [
                'id' => 275705171,
                'name' => '科技园',
                'phone' => '',
                'address' => '科技园',
                'longitude' => 113.94569397,
                'latitude' => 22.5397472382,
            ],
            [
                'id' => 219944303,
                'name' => '国贸天虹',
                'phone' => '0755-82615000',
                'address' => '罗湖区人民南路3004-1    ',
                'longitude' => 114.119361877,
                'latitude' => 22.5411720276,
            ],
            [
                'id' => 280081680,
                'name' => '测试分店名',
                'phone' => '13800138000',
                'address' => '金光华',
                'longitude' => 114.122703552,
                'latitude' => 22.5404415131,
            ],
        ];
    }

    protected function providerForSync2()
    {
        return [
            [
                'business_name' => '麦当劳',
                'branch_name' => '珠江店',
                'province' => '广东省',
                'city' => '广州市',
                'district' => '海珠区',
                'address' => '中国广东省广州市海珠区艺苑路 12 号',
                'telephone' => '020-89772059',
                'category' => '房产小区',
                'longitude' => '113.32375',
                'latitude' => '23.097486',
            ],
        ];
    }
}
