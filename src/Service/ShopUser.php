<?php

namespace Miaoxing\Shop\Service;

/**
 * @property \Miaoxing\LinkTo\Service\LinkTo $linkTo
 */
class ShopUser extends \miaoxing\plugin\BaseModel
{
    protected $table = 'shopUsers';

    protected $providers = [
        'db' => 'app.db',
    ];

    protected $data = [
        'linkTo' => [],
    ];

    protected $user;

    protected $shop;

    public function getUser()
    {
        $this->user || $this->user = wei()->user()->findOrInitById($this['userId']);

        return $this->user;
    }

    public function getShop()
    {
        $this->shop || $this->shop = wei()->shop()->findOrInitById($this['shopId']);

        return $this->shop;
    }

    /**
     * @param Shop $shop
     * @return string
     */
    public function getShopUserToOptionsByShop(Shop $shop)
    {
        $shopUsers = wei()->shopUser()->curApp()->andWhere(['shopId' => $shop['id']])->findAll();
        $html = '';
        foreach ($shopUsers as $shopUser) {
            $html .= '<option value="' . $shopUser['userId'] . '" >' . $shopUser->getUser()['name'] . '</option>';
        }

        return $html;
    }

    public function afterFind()
    {
        parent::afterFind();
        $this['linkTo'] = $this->linkTo->decode($this['linkTo']);
    }

    public function beforeSave()
    {
        parent::beforeSave();
        $this['linkTo'] = $this->linkTo->encode($this['linkTo']);
    }
}
