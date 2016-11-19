<?php

namespace Miaoxing\Shop\Controller\Admin;

class ShopUsers extends \miaoxing\plugin\BaseController
{
    protected $controllerName = '店员管理';

    protected $actionPermissions = [
        'index' => '列表',
        'update' => '修改',
    ];

    public function indexAction($req)
    {
        switch ($req['_format']) {
            case 'json':
                $namespace = wei()->app->getNamespace();
                $shopUsers = wei()->shopUser()->curApp();
                $shopUsers->select('user.*, shopUsers.shopId, shopUsers.userId, shopUsers.linkTo');
                $shopUsers->leftJoin($namespace . '.user', 'shopUsers.userId = ' . $namespace . '.user.id');
                $shopUsers->andWhere(['shopUsers.shopId' => $req['id']]);

                // 姓名筛选
                if ($req['name']) {
                    $shopUsers->andWhere('name LIKE ?', '%' . $req['name'] . '%');
                }

                // 昵称筛选
                if ($req['nickName']) {
                    $shopUsers->andWhere('nickName LIKE ?', '%' . $req['nickName'] . '%');
                }

                // 电话号码筛选
                if ($req['mobile']) {
                    $shopUsers->andWhere('mobile LIKE ?', '%' . $req['mobile'] . '%');
                }

                $users = [];
                /** @var \Miaoxing\Shop\Service\ShopUser $shopUser */
                foreach ($shopUsers as $shopUser) {
                    $users[] = $shopUser->toArray() + [
                            'user' => $shopUser->getUser()->toArray()
                        ];
                }

                return $this->suc([
                    'data' => $users,
                    'page' => $req['page'],
                    'rows' => $req['rows'],
                    'records' => count($users),
                ]);

            default:
                return get_defined_vars();
        }
    }

    public function updateAction($req)
    {
        $validator = wei()->validate(array(
            // 待验证的数据
            'data' => [
                'shopId' => $req['shopId'],
                'userId' => $req['userId'],
            ],
            // 验证规则数组
            'rules' => [
                'shopId' => [
                    'required' => true
                ],
                'userId' => [
                    'required' => true
                ],
            ],
            // 数据项名称的数组,用于错误信息提示
            'names' => [
                'shopId' => '商城ID',
                'userId' => '用户ID'
            ]
        ));
        if (!$validator->isValid()) {
            $firstMessage = $validator->getFirstMessage();
            return json_encode(array("code" => -7, "message" => $firstMessage));
        }

        wei()->shopUser()->curApp()->findOrInit(['shopId' => $req['shopId'], 'userId' => $req['userId']])->save($req);
        return $this->suc();
    }

}
