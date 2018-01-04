<?php

namespace Miaoxing\Shop\Controller;

class Shop extends \Miaoxing\Plugin\BaseController
{
    protected $guestPages = ['shop'];

    public function indexAction($req)
    {
        $shops = wei()->shop();

        $shops->enabled();

        $shops->desc('id');

        if ($req['province']) {
            $shops->andWhere(['province' => $req['province']]);
        }

        if ($req['city']) {
            $shops->andWhere(['city' => $req['city']]);
        }

        if ($req['search']) {
            $shops->andWhere('(name LIKE ?) OR (address LIKE ?)', [
                '%' . $req['search'] . '%',
                '%' . $req['search'] . '%',
            ]);
        }

        // 查找门店的工作人员
        $users = [];
        $shops->findAll();
        foreach ($shops as $shop) {
            $userIds = wei()->shopUser()->select('userId')->fetchAll(['shopId' => $shop['id']]);
            if ($userIds) {
                $userIds = wei()->coll->column($userIds, 'userId');
                $users[$shop['id']] = wei()->user()
                    ->select('name')
                    ->limit(3)
                    ->where("name != ''")
                    ->findAll(['id' => $userIds])
                    ->getAll('name');
            } else {
                $users[$shop['id']] = [];
            }
        }

        $headerTitle = '附近' . ($this->setting('shop.name') ?: '门店');
        $userTitle = $this->setting('shop.titleUser') ?: '工作人员';

        return get_defined_vars();
    }

    /**
     * 生成门店的区域数据,选择下拉菜单筛选
     *
     * @param $req
     * @return \Wei\Response
     */
    public function regionsAction($req)
    {
        if (!$req['parentId']) {
            $data = wei()->shop()->select('DISTINCT province AS value')->fetchAll();
        } else {
            $data = wei()->shop()->select('DISTINCT city AS value')->fetchAll(['province' => $req['parentId']]);
        }

        return $this->suc([
            'data' => $data,
        ]);
    }

    public function usersAction($req)
    {
        $shop = wei()->shop()->findOneById($req['id']);

        $shopUsers = $shop->getShopUsers();

        $headerTitle = ($this->setting('shop.titleUser') ?: '工作人员') . '列表';

        return get_defined_vars();
    }
}
