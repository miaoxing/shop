<?php $view->layout() ?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/shop/css/shops.css') ?>">
<?= $block->end() ?>

<ul class="list list-intend">
  <?php foreach ($shopUsers as $shopUser) : ?>
    <li class="list-item-link">
      <a class="js-user-link list-item has-feedback"
        href="<?= $shopUser['linkTo']['type'] ? $wei->linkTo->getUrl($shopUser['linkTo']) : 'javascript:;' ?>">
        <div class="list-col shop-user-img">
          <img src="<?= $shopUser->getUser()->getHeadImg() ?>">
        </div>
        <div class="list-col list-middle">
          <h4 class="list-title">
            <?= $shopUser->getUser()->get('name') ?: '暂无' ?>
          </h4>
        </div>
        <?php if ($shopUser['linkTo']['type']) : ?>
          <i class="bm-angle-right list-feedback"></i>
        <?php endif ?>
      </a>
    </li>
  <?php endforeach ?>

  <?php if (!$shopUsers->length()) : ?>
    <li class="list-empty">暂无记录</li>
  <?php endif ?>
</ul>

<?= $block->js() ?>
<script>
  $('.js-user-link').click(function (e) {
    if ($(this).attr('href') == '#') {
      $.info('暂无介绍');
      e.preventDefault();
    }
  });
</script>
<?= $block->end() ?>
