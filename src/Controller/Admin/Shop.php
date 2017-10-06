<?php

namespace Miaoxing\Shop\Controller\Admin;

class Shop extends \miaoxing\plugin\BaseController
{
    protected $controllerName = '门店管理';

    protected $actionPermissions = [
        'index' => '列表',
        'new,create' => '添加',
        'edit,update,updateShop' => '修改',
        'destroy,batchDel' => '删除',
        'upload' => '批量上传',
    ];

    protected $displayPageHeader = true;

    public function indexAction($req)
    {
        switch ($req['_format']) {
            case 'json':
                $shops = wei()->shop();

                // 分页
                $shops->limit($req['rows'])->page($req['page']);

                // 排序
                $shops->desc('id');

                // 编号
                if ($req['ids']) {
                    $shops->andWhere(['id' => explode(',', $req['ids'])]);
                }

                if ($req['province']) {
                    $shops->andWhere(['province' => $req['province']]);
                }

                if ($req['city']) {
                    $shops->andWhere(['city' => $req['city']]);
                }

                $shops->findAll();
                $data = $shops->toArray();

                // 触发查找后事件
                $this->event->trigger('postAdminShopListFind', [$req, &$data]);

                return $this->suc([
                    'data' => $data,
                    'page' => $req['page'],
                    'rows' => $req['rows'],
                    'records' => $shops->count(),
                ]);

            default:
                return get_defined_vars();
        }
    }

    public function newAction($req)
    {
        return $this->editAction($req);
    }

    public function editAction($req)
    {
        $shop = wei()->shop()->findId($req['id']);

        $shopUsers = wei()->shopUser()
            ->curApp()
            ->andWhere(['shopId' => $req['id']])
            ->findAll();

        $users = [];
        foreach ($shopUsers as $shopUser) {
            $users[] = wei()->user()->findById($shopUser['userId'])->toArray();
        }

        return get_defined_vars();
    }

    public function createAction($req)
    {
        return $this->updateAction($req);
    }

    /**
     * 保存门店信息
     * @param $req
     * @return \Wei\Response
     */
    public function updateAction($req)
    {
        $shop = wei()->shop()->findId($req['id']);

        $ret = $shop->create($req);

        return $ret;
    }

    public function updateShopAction($req)
    {
        $data = [
            'name' => (string) $req['name'],
            'phone' => (string) $req['phone'],
            'province' => (string) $req['province'],
            'city' => (string) $req['city'],
            'address' => (string) $req['address'],
        ];
        $mapResult = $this->getLatLngByAddress($req['province'] . $req['city'] . $req['address'] . $req['name']);
        if ($mapResult['status'] == 0) {
            $data['lat'] = $mapResult['result']['location']['lat'];
            $data['lng'] = $mapResult['result']['location']['lng'];
        }
        if ($req['id']) {
            wei()->shop()->findOne($req['id'])->save($data);
        } else {
            $data['enable'] = 1;
            $data['createTime'] = date('Y-m-d H:i:s');
            wei()->shop()->save($data);
        }
        if (!$req['noReturn']) {
            return $this->suc();
        }
    }

    /**
     * 根据地址获取经纬度
     */
    public function getLatLngByAddress($address)
    {
        $address = urlencode($address);
        $baiduUrl = 'http://api.map.baidu.com/geocoder/v2/?address=';
        $baiduUrl .= $address . '&output=json&ak=lquVnNEcl0pEiMgZFXcnQ5Kq';

        return wei()->http->getJson($baiduUrl);
    }

    /**
     * 删除
     */
    public function destroyAction($req)
    {
        $shop = wei()->shop()->findOneById($req['id']);

        $ret = wei()->event->until('preShopDestroy', [$shop]);
        if ($ret) {
            return $ret;
        }

        $shop->destroy();

        return $this->suc();
    }

    /**
     * 批量删除
     *
     * @param $req
     * @return $this
     */
    public function batchDelAction($req)
    {
        foreach ((array) $req['ids'] as $key => $value) {
            $ret = $this->destroy($value);
            if ($ret['code'] !== 1) {
                return $ret;
            }
        }

        return $this->suc();
    }

    protected function destroy($id)
    {
        $shop = wei()->shop()->findOneById($id);

        $ret = wei()->event->until('preShopDestroy', [$shop]);
        if ($ret) {
            return $ret;
        }

        $shop->destroy();

        return $this->suc();
    }

    /**
     * @param $req
     * @return $this
     */
    public function uploadAction($req)
    {
        foreach ((array) $req['shops'] as $key => $shop) {
            $data = [
                'name' => $shop[0],
                'phone' => $shop[1],
                'province' => $shop[2],
                'city' => $shop[3],
                'address' => $shop[4],
                'noReturn' => true,
            ];
            $r = $this->updateShopAction($data);
        }

        return $this->suc();
    }
}
