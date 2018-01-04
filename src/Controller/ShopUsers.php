<?php

namespace Miaoxing\Shop\Controller;

class ShopUsers extends \Miaoxing\Plugin\BaseController
{
    public function indexAction($req)
    {
        $namespace = wei()->app->getNamespace();
        $shopUsers = wei()->shopUser()->curApp();
        $shopUsers->select('user.*, shopUsers.shopId, shopUsers.userId, shopUsers.linkTo');
        $shopUsers->leftJoin($namespace . '.user', 'shopUsers.userId = ' . $namespace . '.user.id');
        $shopUsers->andWhere(['shopUsers.shopId' => $req['id']]);

        $users = [];
        /** @var \Miaoxing\Shop\Service\ShopUser $shopUser */
        foreach ($shopUsers as $shopUser) {
            $users[] = $shopUser->toArray() + [
                    'user' => $shopUser->getUser()->toArray(),
                ];
        }

        return $this->suc([
            'data' => $users,
            'page' => $req['page'],
            'rows' => $req['rows'],
            'records' => count($users),
        ]);
    }
}
