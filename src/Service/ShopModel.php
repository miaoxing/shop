<?php

namespace Miaoxing\Shop\Service;

use Miaoxing\Plugin\Model\CastTrait;
use Miaoxing\Plugin\Model\GetSetTrait;
use Miaoxing\Plugin\Model\ReqQueryTrait;
use Miaoxing\Shop\Metadata\ShopTrait;

/**
 * ShopModel
 */
class ShopModel extends Shop
{
    use ShopTrait;
    use CastTrait;
    use ReqQueryTrait;
    use GetSetTrait;

    protected $table = 'shop';

    public function afterFind()
    {
        //
    }
}
