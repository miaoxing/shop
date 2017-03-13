<?php $view->layout() ?>

<?= $block('css') ?>
<link rel="stylesheet" href="<?= $asset('plugins/shop/css/admin/shop.css') ?>"/>
<?= $block->end() ?>

<div class="page-header">
  <div class="pull-right">
    <a class="btn btn-default" href="<?= $url('admin/shop/index') ?>">返回列表</a>
  </div>
  <h1>
    微官网
    <small>
      <i class="fa fa-angle-double-right"></i>
      门店列表
    </small>
  </h1>
</div>
<!-- /.page-header -->

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <form id="shop-form" class="form-horizontal" method="post" role="form">

      <div class="form-group">
        <label class="col-sm-2 control-label" for="name">
          <span class="text-warning">*</span>
          门店名
        </label>

        <div class="col-sm-4">
          <input type="text" class="form-control" name="name" id="name" data-rule-required="true">
        </div>
        <label for="name" class="col-sm-6 help-text">
          门店名不得包含区域地址信息（如，北京市XXX公司）
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
        <label class="col-lg-2 control-label">
          选择用户
        </label>

        <div class="col-lg-4 shop-users-picker">
          <input type="text" class="form-control user-typeahead">
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="link-to">
          介绍链接
        </label>

        <div class="col-lg-4">
          <p class="js-link-to form-control-static" id="link-to"></p>
        </div>

        <label class="col-lg-6 help-text" for="link-to">
          设置后,前台点击门店名称可跳转到相应的页面
        </label>
      </div>

      <div class="form-group">
        <label class="col-sm-2 control-label" for="category">
          <span class="text-warning">*</span>
          类目
        </label>

        <div class="col-sm-4">
          <select name="category" id="category" class="form-control">
            <option>美食</option>
            <option>基础设施</option>
            <option>医疗保健</option>
            <option>生活服务</option>
            <option>休闲娱乐</option>
            <option>购物</option>
            <option>运动健身</option>
            <option>汽车</option>
            <option>酒店宾馆</option>
            <option>旅游景点</option>
            <option>文化场馆</option>
            <option>教育学校</option>
            <option>银行金融</option>
            <option>地名地址</option>
            <option>房产小区</option>
            <option>丽人</option>
            <option>结婚</option>
            <option>亲子</option>
            <option>公司企业</option>
            <option>机构团体</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-2 control-label" for="phone">
          电话
        </label>

        <div class="col-sm-4">
          <input type="text" class="form-control" name="phone" id="phone">
        </div>

        <label class="col-lg-6 help-text" for="phone">
          留空则前台不显示,如果用于微信门店,则必须填写电话
        </label>
      </div>

      <div class="form-group">
        <label class="col-sm-2 control-label" for="province">
          <span class="text-warning">*</span>
          省市
        </label>

        <div class="col-sm-2 p-r-0">
          <select class="js-cascading-item province form-control" id="province" name="province">
          </select>
        </div>
        <div class="col-sm-2">
          <select class="js-cascading-item city form-control" id="city" name="city">
          </select>
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
          <div id="map"></div>
        </div>
      </div>

      <input type="hidden" name="lat" id="lat"/>
      <input type="hidden" name="lng" id="lng"/>
      <input type="hidden" name="id" id="id"/>

      <div class="clearfix form-actions form-group">
        <div class="col-sm-offset-2">
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
<?php require $this->getFile('user:admin/user/usersPicker.php') ?>
<?php require $this->getFile('user:admin/user/richInfo.php') ?>

<?= $block('js') ?>
<script>
  var shop = <?= $shop->toJson() ?>;
  require(['linkTo', 'form', 'validator', 'comps/jquery-baidu-map-picker/jquery-baidu-map-picker'], function (linkTo) {
    $('#shop-form')
      .loadJSON(shop)
      .ajaxForm({
        url: '<?= $url('admin/shop/update') ?>',
        dataType: 'json',
        beforeSubmit: function (arr, $form, options) {
          return $form.valid();
        },
        success: function (result) {
          $.msg(result, function () {
            if (result.code > 0) {
              window.location = $.url('admin/shop/index');
            }
          });
        }
      });

    // 初始化链接选择器
    $('.js-link-to').linkTo({
      data: shop.linkTo,
      hide: {
        keyword: true,
        decorator: true
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


