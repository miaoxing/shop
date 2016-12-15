<?php $view->layout() ?>

<?= $block('css') ?>
<link rel="stylesheet" href="<?= $asset('plugins/admin/assets/filter.css') ?>"/>
<?= $block->end() ?>

<!-- /.page-header -->
<div class="page-header">
  <a class="btn btn-default pull-right" href="<?= $url('admin/shop/index') ?>">返回列表</a>

  <h1>
    店员管理
  </h1>
</div>

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">
      <div class="well form-well m-b">
        <form class="js-user-form form-horizontal filter-form" role="form">
          <div class="form-group form-group-sm">
            <label class="col-md-1 control-label" for="nickName">用户昵称：</label>

            <div class="col-md-3">
              <input type="text" class="form-control" id="nickName" name="nickName">
            </div>

            <label class="col-md-1 control-label" for="name">姓名：</label>

            <div class="col-md-3">
              <input type="text" class="form-control" id="name" name="name">
            </div>

            <label class="col-md-1 control-label" for="mobile">手机号码：</label>

            <div class="col-md-3">
              <input type="text" class="form-control" id="mobile" name="mobile">
            </div>
          </div>
        </form>
      </div>

      <table id="record-table" class="record-table table table-bordered table-hover">
        <thead>
        <tr>
          <th style="width: 260px">用户</th>
          <th style="width: 130px">姓名</th>
          <th style="width: 130px">手机</th>
          <th style="width: 130px">地区</th>
          <th>链接</th>
          <th style="width: 150px">注册时间</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>

    </div>
    <!-- /.table-responsive -->
    <!-- PAGE CONTENT ENDS -->
  </div>
  <!-- /col -->
</div>
<!-- /row -->


<script type="text/html" id="link-to-control">
  <form class="form-horizontal set-link-to" data-data="<%= linkToData %>"></form>
</script>

<?php require $view->getFile('user:admin/user/richInfo.php') ?>
<?php require $view->getFile('@link-to/link-to/link-to.php') ?>

<?= $block('js') ?>
<script>
  require(['assets/admin/user', 'dataTable', 'template', 'jquery-deparam', 'form', 'linkTo'], function () {
    $('.js-user-form').loadParams().update(function () {
      recordTable.reload($(this).serialize(), false);
    });

    var recordTable = $('#record-table').dataTable({
      ajax: {
        url: $.queryUrl('admin/shop-users.json')
      },
      columns: [
        {
          data: 'user.nickName',
          sClass: 'user-media-td',
          render: function (data, type, full) {
            return template.render('user-info-tpl', full.user);
          }
        },
        {
          data: 'user.name'
        },
        {
          data: 'user.mobile'
        },
        {
          data: 'user.country',
          render: function (data, type, full) {
            return full.user.country + ' ' + full.user.province + ' ' + full.user.city;
          }
        },
        {
          data: 'linkTo',
          render: function (data, type, full) {
            full.linkToData = JSON.stringify(data);
            return template.render('link-to-control', full);
          }
        },
        {
          data: 'createTime',
          sClass: 'text-center',
          render: function (data) {
            return data.substr(0, 16);
          }
        }
      ],
      drawCallback: function () {
        // 初始化linkTo选择器
        this.find('.set-link-to').each(function () {
          var $this = $(this);
          var rowData = recordTable.fnGetData($this.parents('tr:first')[0]);
          $this.linkTo({
            data: rowData.linkTo,
            linkText: '设置',
            hide: {
              tel: true,
              browser: true
            },
            update: function (data) {
              $.ajax({
                url: $.url('admin/shop-users/update'),
                type: 'post',
                dataType: 'json',
                data: {
                  shopId: rowData.shopId,
                  userId: rowData.id,
                  linkTo: data
                }
              });
            }
          });
        });
      }
    });

  });
</script>
<?= $block->end() ?>

