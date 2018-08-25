<?php

namespace MiaoxingDoc\Shop {

    /**
     * @property    \Miaoxing\Shop\Service\Shop $shop 门店
     * @method      \Miaoxing\Shop\Service\Shop|\Miaoxing\Shop\Service\Shop[] shop()
     *
     * @property    \Miaoxing\Shop\Service\ShopModel $shopModel ShopModel
     * @method      \Miaoxing\Shop\Service\ShopModel|\Miaoxing\Shop\Service\ShopModel[] shopModel()
     *
     * @property    \Miaoxing\Shop\Service\ShopUser $shopUser 店员
     * @method      \Miaoxing\Shop\Service\ShopUser|\Miaoxing\Shop\Service\ShopUser[] shopUser()
     */
    class AutoComplete
    {
    }
}

namespace {

    /**
     * @return MiaoxingDoc\Shop\AutoComplete
     */
    function wei()
    {
    }

    /** @var Miaoxing\Shop\Service\Shop $shop */
    $shop = wei()->shop;

    /** @var Miaoxing\Shop\Service\ShopModel $shopModel */
    $shop = wei()->shopModel();

    /** @var Miaoxing\Shop\Service\ShopModel|Miaoxing\Shop\Service\ShopModel[] $shopModels */
    $shops = wei()->shopModel();

    /** @var Miaoxing\Shop\Service\ShopUser $shopUser */
    $shopUser = wei()->shopUser;
}
