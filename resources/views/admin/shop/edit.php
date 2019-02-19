<?php

$view->layout();
?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/shop/css/admin/shop.css') ?>"/>
<?= $block->end() ?>

<?= $block('header-actions') ?>
  <a class="btn btn-default" href="<?= $url('admin/shop/index') ?>">返回列表</a>
<?= $block->end() ?>

<div class="row">
  <div class="col-12">
    <!-- PAGE CONTENT BEGINS -->
    <form id="shop-form" class="form-horizontal" method="post" role="form">

      <fieldset>
        <legend class="text-muted text-xl">
          基本信息
        </legend>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="name">
            <span class="text-warning">*</span>
            名称
          </label>

          <div class="col-sm-4">
            <input type="text" class="form-control" name="name" id="name" data-rule-required="true">
          </div>
          <label for="name" class="col-sm-6 help-text">
            名称不得包含区域地址信息（如，北京市XXX公司）
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="branch-name">
            分店名
          </label>

          <div class="col-sm-4">
            <input type="text" class="form-control" name="branchName" id="branch-name">
          </div>
          <label for="branch-name" class="col-sm-6 help-text">
            分店名不得包含区域地址信息（如，“北京国贸店”中的“北京”）
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="categories">
            类目
          </label>

          <div class="col-sm-4">
            <select class="js-categories form-control" name="categories[]" id="categories" multiple>
              <?php foreach (wei()->shop->getCategories() as $category) : ?>
                <option><?= $category ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="province">
            <span class="text-warning">*</span>
            省市
          </label>

          <div class="col-sm-4">
            <div class="form-row">
              <div class="col">
                <select class="js-cascading-item province form-control" id="province" name="province">
                </select>
              </div>
              <div class="col">
                <select class="js-cascading-item city form-control" id="city" name="city">
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="address">
            <span class="text-warning">*</span>
            地址
          </label>

          <div class="col-sm-4">
            <input type="text" class="form-control" name="address" id="address" data-rule-required="true"
              placeholder="请输入地址搜索">
          </div>

          <label class="col-lg-6 help-text" for="address">
            地址不得包含区域信息（如，“广东省深圳市南山区”中的“广东省深圳市”）
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">
            地图
          </label>

          <div class="col-sm-6">
            <div id="map" class="map"></div>
          </div>
        </div>

        <input type="hidden" name="lat" id="lat"/>
        <input type="hidden" name="lng" id="lng"/>
      </fieldset>

      <fieldset>
        <legend class="text-muted text-xl">
          服务信息
        </legend>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="photo-list">
            图片
          </label>

          <div class="col-lg-4">
            <input class="js-photo-list" id="photo-list" type="text"  name="photo_list[][photo_url]">
          </div>
          <label class="col-lg-6 help-text" for="photo-list">
            支持.jpg .jpeg .bmp .png格式，大小不超过5M
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="phone">
            电话
          </label>

          <div class="col-sm-4">
            <input type="text" class="form-control" name="phone" id="phone">
          </div>

          <label class="col-lg-6 help-text" for="phone">
            固定电话需加区号；区号、分机号均用“-”连接
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="avg-price">
            人均价格
          </label>

          <div class="col-sm-4">
            <input type="text" class="form-control" name="avg_price" id="avg-price">
          </div>

          <label class="col-lg-6 help-text" for="avg-price">
            大于零的整数，须如实填写，默认单位为人民币
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="open-time">
            营业时间
          </label>

          <div class="col-sm-4">
            <input type="text" class="form-control" name="open_time" id="open-time">
          </div>

          <label class="col-lg-6 help-text" for="open-time">
            如，10:00-21:00
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="recommend">
            推荐
          </label>

          <div class="col-sm-4">
            <textarea type="text" class="form-control" name="recommend" id="recommend"></textarea>
          </div>

          <label class="col-lg-6 help-text" for="recommend">
            如，推荐菜，推荐景点，推荐房间
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="special">
            特色服务
          </label>

          <div class="col-sm-4">
            <textarea type="text" class="form-control" name="special" id="special"></textarea>
          </div>

          <label class="col-lg-6 help-text" for="special">
            如，免费停车，WiFi
          </label>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="introduction">
            简介
          </label>

          <div class="col-sm-4">
            <textarea type="text" class="form-control" name="introduction" id="introduction"></textarea>
          </div>

          <label class="col-lg-6 help-text" for="introduction">
            对品牌或门店的简要介绍
          </label>
        </div>
      </fieldset>

      <fieldset>
        <legend class="text-muted text-xl">
          更多信息
        </legend>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="link-to">
            介绍链接
          </label>

          <div class="col-lg-4">
            <p class="js-link-to form-control-static" id="link-to"></p>
          </div>

          <label class="col-lg-6 help-text" for="link-to">
            设置后,前台点击名称可跳转到相应的页面
          </label>
        </div>

        <?php if (wei()->shop->enableShopUser) { ?>
          <div class="form-group">
            <label class="col-lg-2 control-label">
              选择店员
            </label>

            <div class="col-lg-4 shop-users-picker">
              <input type="text" class="form-control user-typeahead">
            </div>
          </div>
        <?php } ?>

        <div class="form-group">
          <label class="col-lg-2 control-label" for="out-id">
            外部编号
          </label>

          <div class="col-lg-4">
            <input type="text" class="form-control" id="out-id" name="out_id">
          </div>

          <label class="col-lg-6 help-text" for="out-id">
            可用于数据关联,同步等
          </label>
        </div>
      </fieldset>

      <?php $event->trigger('adminShopsEdit') ?>

      <input class="js-id" type="hidden" name="id" id="id"/>

      <div class="clearfix form-actions form-group">
        <div class="offset-sm-2">
          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check"></i>
            提交
          </button>
          &nbsp; &nbsp; &nbsp;
          <a class="btn btn-default" href="<?= $url('admin/shop/index') ?>">
            <i class="fa fa-undo"></i>
            返回列表
          </a>
        </div>
      </div>
    </form>
  </div>
  <!-- PAGE CONTENT ENDS -->
</div><!-- /.col -->
<!-- /.row -->

<?php require $view->getFile('@link-to/link-to/link-to.php') ?>
<?php require $this->getFile('@user/admin/user/usersPicker.php') ?>
<?php require $this->getFile('@user/admin/user/richInfo.php') ?>

<?= $block->js() ?>
<script>
  var shop = <?= $shop->toJson() ?>;
  require([
    'linkTo', 'form', 'validator',
    'comps/jquery-baidu-map-picker/jquery-baidu-map-picker',
    'plugins/admin/js/image-upload',
    'plugins/app/libs/jquery.populate/jquery.populate',
    'comps/select2/select2.min',
    'css!comps/select2/select2',
    'css!comps/select2-bootstrap-css/select2-bootstrap'
  ], function () {
    $('#shop-form')
      .populate(shop)
      .ajaxForm({
        url: '<?= $url('admin/shop/update') ?>',
        dataType: 'json',
        beforeSubmit: function (arr, $form, options) {
          return $form.valid();
        },
        success: function (ret) {
          $.msg(ret, function () {
            if (ret.id) {
              $('.js-id').val(ret.id);
            }

            if (ret.code === 1) {
              window.location = $.url('admin/shop/index');
            }
          });
        }
      });

    // 初始化链接选择器
    $('.js-link-to').linkTo({
      data: shop.linkTo,
      hide: {
        keyword: true
      }
    });

    $('#map').baiduMapPicker({
      lat: shop.lat,
      lng: shop.lng,
      ak: '<?= wei()->baiduApi->getBrowserAccessKey() ?>',
      latEl: '#lat',
      lngEl: '#lng',
      provinceEl: '#province',
      cityEl: '#city',
      localityEl: '#address',
      autocompleteEl: '#address'
    });

    var photoUrls = [];
    $.each(shop.photo_list, function (i, photo) {
      photoUrls.push(photo.photo_url);
    });
    $('.js-photo-list').imageUpload({
      max: 10,
      images: photoUrls
    });

    $('.js-categories').select2({
      maximumSelectionSize: 3
    });
  });

  require(['comps/jquery-cascading/jquery-cascading'], function () {
    $('.js-cascading-item').cascading({
      url: $.url('regions.json', {parentId: '中国'}),
      valueKey: 'label',
      values: [shop.province, shop.city]
    });
  });

  require(['plugins/user/js/admin/users-picker'], function (UsersPicker) {
    var usersPicker = new Object(UsersPicker);
    usersPicker.init({
      $el: $('.shop-users-picker'),
      users: <?= json_encode($users); ?>
    });
  });
</script>
<?= $block->end() ?>


