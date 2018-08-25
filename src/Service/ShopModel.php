<?php

namespace Miaoxing\Shop\Service;

use Miaoxing\Plugin\BaseModelV2;
use Miaoxing\Shop\Metadata\ShopTrait;

/**
 * ShopModel
 */
class ShopModel extends BaseModelV2
{
    use ShopTrait;

    protected $table = 'shop';
}
