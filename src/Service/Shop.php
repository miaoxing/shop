<?php

namespace Miaoxing\Shop\Service;

/**
 * 门店
 */
class Shop extends \miaoxing\plugin\BaseModel
{
    protected $createdAtColumn = 'created_at';

    protected $updatedAtColumn = 'updated_at';

    protected $createdByColumn = 'created_by';

    protected $updatedByColumn = 'updated_by';

    protected $data = [
        'province' => '广东',
        'city' => '深圳',
        'lat' => '22.546054',
        'lng' => '114.025974',
        'enable' => 1,
        'linkTo' => [],
        'photo_list' => [],
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
        $this['photo_list'] = (array) json_decode($this['photo_list'], true);
        $this['categories'] = (array) json_decode($this['categories'], true);
    }

    public function beforeSave()
    {
        parent::beforeSave();
        $this['linkTo'] = $this->linkTo->encode($this['linkTo']);
        $this['photo_list'] = json_encode($this['photo_list'], JSON_UNESCAPED_SLASHES);
        $this['categories'] = json_encode($this['categories'], JSON_UNESCAPED_SLASHES);
    }

    public function afterSave()
    {
        parent::afterSave();
        $this['photo_list'] = (array) json_decode($this['photo_list'], true);
        $this['categories'] = (array) json_decode($this['categories'], true);
    }

    public function getCategories()
    {
        return require wei()->view->getFile('@shop/../data/categories.php');
    }

    public function create($req)
    {
        // 清理空数组的数据
        if (!$req['photo_list'][0]['photo_url']) {
            $req['photo_list'] = [];
        }

        $this->event->trigger('preShopSave', $this);

        $this->save($req);

        wei()->shopUser()->curApp()->delete(['shopId' => $this['id']]);
        if ($req['userIds']) {
            foreach ($req['userIds'] as $userId) {
                wei()->shopUser()->curApp()->findOrInit(['userId' => $userId, 'shopId' => $this['id']])->save();
            }
        }

        $ret = $this->event->until('postShopSave', $this);
        if ($ret) {
            // 返回门店编号以便前台使用
            $ret['id'] = $this['id'];

            return $ret;
        }

        return $this->suc();
    }
}
