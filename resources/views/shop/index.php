<?php

$view->layout();
$wei->page->addAsset('comps/dropdown-menu/dropdown-menu.css');
?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/shop/css/shops.css') ?>">
<?= $block->end() ?>

<div class="filter-dropdown nav-dropdown">
  <ul class="nav-tabs tabs-justified border-top-bottom">
    <li class="dropdown">
      <a class="text-active-primary" href="javascript: void(0)" data-toggle="dropdown" data-target="#search">
        <span>搜索</span>&nbsp;&nbsp;
        <i class="icon small icon-chevron-down"></i>
      </a>
    </li>
  </ul>
  <div class="menu-content">
    <div id="search" class="dropdown-menu fade border-bottom">
      <div class="menu sub">
        <form action="" class="js-dist-form form form-inset mt-2 control-label-md">
          <?php foreach ($req->getQueries() as $key => $value) : ?>
            <input type="hidden" name="<?= $e($key) ?>" value="<?= $e($value) ?>">
          <?php endforeach ?>

          <div class="form-body">
            <div class="form-group">
              <label for="nick-name" class="col-form-label">省份</label>
              <div class="col-control">
                <select class="js-cascading-item province form-control" name="province">
                  <option>全部</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="product-name" class="col-form-label">城市</label>
              <div class="col-control">
                <select class="js-cascading-item form-control" name="city">
                  <option>全部</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="product-name" class="col-form-label">名称</label>
              <div class="col-control">
                <input class="form-control" type="text" name="search" value="<?= $e($req['search']) ?>">
              </div>
            </div>
          </div>
          <div class="form-group form-footer">
            <button type="submit" class="btn btn-brand btn-primary btn-block">搜索</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php foreach ($shops as $shop) : ?>
  <ul class="shop-list list">
    <li class="list-item-link">
      <a class="list-item has-feedback"
        href="<?= $shop['linkTo']['type'] ? $wei->linkTo->getUrl($shop['linkTo']) : 'javascript:;' ?>">
        <h4 class="list-title">
          <?= $shop['name'] ?>
          <span class="js-distance-<?= $shop['id'] ?> shop-distance text-muted"></span>
        </h4>
        <?php if ($shop['linkTo']['type']) : ?>
          <i class="bm-angle-right list-feedback"></i>
        <?php endif ?>
      </a>
    </li>

    <?php if ($shop['phone']) : ?>
      <li class="list-item-link">
        <a class="list-item text-muted has-feedback" href="tel:<?= $shop['phone'] ?>">
          <i class="shop-icon">&#xe603;</i>
          <?= $shop['phone'] ?>
          <i class="bm-angle-right list-feedback"></i>
        </a>
      </li>
    <?php endif ?>

    <li class="list-item-link">
      <a class="list-item text-muted has-feedback" href="http://api.map.baidu.com/marker?<?= http_build_query([
        'location' => $shop['lat'] . ',' . $shop['lng'],
        'title' => $shop['name'],
        'content' => $shop['name'],
        'output' => 'html',
      ]) ?>">
        <i class="shop-icon">&#xe601;</i>
        <?= $shop['province'] . $shop['city'] . $shop['address'] ?>
        <i class="bm-angle-right list-feedback"></i>
      </a>
    </li>

    <?php if ($users[$shop['id']]) : ?>
      <li class="list-item-link">
        <a class="list-item text-muted has-feedback" href="<?= $url('shop/%s/users', $shop['id']) ?>">
          <i class="shop-icon">&#xe600;</i>
          <?= $userTitle ?>: <?= implode(', ', $users[$shop['id']]) ?>
          <?= count($users[$shop['id']]) === 3 ? '...' : '' ?>
          <i class="bm-angle-right list-feedback"></i>
        </a>
      </li>
    <?php endif ?>
  </ul>
<?php endforeach ?>

<?php if (!$shops->length()) : ?>
  <ul class="list">
    <li class="list-empty">暂无记录</li>
  </ul>
<?php endif ?>

<?= $block->js() ?>
<script>
  require([
    'comps/dropdown-menu/dropdown-menu',
    'comps/jquery-cascading/jquery-cascading',
    'comps/jquery.cookie/jquery.cookie'
  ], function () {
    $.cookie.json = true;

    $('.js-cascading-item').cascading({
      url: $.url('shop/regions.json'),
      labelKey: 'value',
      values: <?= json_encode([$req['province'], $req['city']]) ?>
    });

    var shops = <?= $shops->toJson(['id', 'lat', 'lng']) ?>;
    getLocation(function (location, save) {
      if (!location.lat) {
        return;
      }

      if (save) {
        $.cookie('position', location);
      }

      $.each(shops, function (key, shop) {
        var distanceText = '';
        var distance = getDistance(shop, location);
        if (distance > 1000) {
          distance = (distance / 1000).toFixed(1);
          distanceText = distance + ' km';
        } else {
          distanceText = parseInt(distance) + ' m';
        }
        $('.js-distance-' + shop.id).text(distanceText);
      });
    });

    function getLocation(callback) {
      if (!navigator.geolocation) {
        return;
      }

      var position = $.cookie('position');
      if (position) {
        callback(position);
        return;
      }

      navigator.geolocation.getCurrentPosition(function (position) {
        callback({
          lat: position.coords.latitude + '',
          lng: position.coords.longitude + ''
        }, true);
      }, function (err) {
        callback({
          lat: false,
          lng: false
        }, true);
      }, {
        enableHighAcuracy: true,
        timeout: 5000,
        maximumAge: 3000
      });
    }
  });

  function getDistance(start, end) {
    var EARTH_RADIUS = 6378.137;
    var radLat1 = rad(start.lat);
    var radLat2 = rad(end.lat);
    var a = radLat1 - radLat2;
    var b = rad(start.lng) - rad(end.lng);
    var s = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(a / 2), 2) +
      Math.cos(radLat1) * Math.cos(radLat2) * Math.pow(Math.sin(b / 2), 2)));
    s = s * EARTH_RADIUS;
    s = Math.round(s * 10000) / 10;
    return parseInt(s);
  }

  function rad(d) {
    return d * Math.PI / 180.0;
  }
</script>
<?= $block->end() ?>
