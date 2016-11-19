<?php

namespace Miaoxing\Shop\Service;

class Shop extends \miaoxing\plugin\BaseModel
{
    protected $data = [
        'province' => '广东',
        'city' => '深圳',
        'lat' => '22.546054',
        'lng' => '114.025974',
        'enable' => 1,
        'linkTo' => [],
    ];

    /**
     * @var ShopUser|ShopUser[]
     */
    protected $shopUsers;

    /**
     * @var null|array
     */
    protected $shops;

    /**
     * Repo: 根据门店编号获取名称
     *
     * @param int $id
     * @return string
     */
    public function getName($id)
    {
        if ($this->shops === null) {
            // TODO record data有默认值时,indexBy会出错
            $this->shops = wei()->shop()
                ->select('id, name')
                ->enabled()
                ->fetchAll();
            $this->shops = wei()->coll->indexBy($this->shops, 'id');
        }
        if (isset($this->shops[$id])) {
            return $this->shops[$id]['name'];
        } else {
            return '';
        }
    }

    public function getShopToOptions()
    {
        $shops = wei()->shop()->enabled()->findAll();
        $html = '';
        foreach ($shops as $shop) {
            $html .= '<option value="' . $shop['id'] . '" >' . $shop['name'] . '</option>';
        }

        return $html;
    }

    public function getFullAddress()
    {
        return $this['province'] . $this['city'] . $this['address'];
    }

    public function getShopUsers()
    {
        $this->shopUsers || $this->shopUsers = wei()->shopUser()->curApp()->findAll(['shopId' => $this['id']]);

        return $this->shopUsers;
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
