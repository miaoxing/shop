<?php

namespace Miaoxing\Shop\Metadata;

/**
 * ShopTrait
 *
 * @property int $id
 * @property int $wechatLocationId 微信门店编号 0未导入 -1导入失败
 * @property bigint $wechatPoiId
 * @property string $name
 * @property string $branchName 分店名
 * @property string $photoList
 * @property string $categories 门店分类
 * @property string $province
 * @property string $city
 * @property string $address
 * @property bool $offsetType 坐标类型
 * @property string $lat
 * @property string $lng
 * @property string $phone
 * @property string $recommend
 * @property string $special
 * @property string $introduction
 * @property string $openTime
 * @property int $avgPrice
 * @property string $linkTo
 * @property bool $availableState
 * @property string $resultMessage 审核结果的信息
 * @property bool $updateStatus
 * @property string $createdAt
 * @property int $createdBy
 * @property string $updatedAt
 * @property int $updatedBy
 * @property bool $enable
 * @property string $sourceCode 来源标识
 * @property string $outId 外部系统编号,可用于数据关联,同步等
 */
trait ShopTrait
{
    /**
     * @var array
     * @see CastTrait::$casts
     */
    protected $casts = [
        'id' => 'int',
        'wechatLocationId' => 'int',
        'wechat_poi_id' => 'bigint',
        'name' => 'string',
        'branchName' => 'string',
        'photo_list' => 'string',
        'categories' => 'string',
        'province' => 'string',
        'city' => 'string',
        'address' => 'string',
        'offset_type' => 'bool',
        'lat' => 'string',
        'lng' => 'string',
        'phone' => 'string',
        'recommend' => 'string',
        'special' => 'string',
        'introduction' => 'string',
        'open_time' => 'string',
        'avg_price' => 'int',
        'linkTo' => 'string',
        'available_state' => 'bool',
        'result_message' => 'string',
        'update_status' => 'bool',
        'created_at' => 'datetime',
        'created_by' => 'int',
        'updated_at' => 'datetime',
        'updated_by' => 'int',
        'enable' => 'bool',
        'source_code' => 'string',
        'out_id' => 'string',
    ];
}
