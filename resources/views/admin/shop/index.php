<?php

$view->layout();
$wei->page->addAsset('comps/jasny-bootstrap/dist/css/jasny-bootstrap.min.css');
?>

<?= $block('header-actions') ?>
<form id="shop-upload-form" class="form-horizontal" method="post" role="form">
  <a class="btn btn-success" href="<?= $url('admin/shop/new') ?>">添加<?= wei()->shop->shopName ?></a>

  <div class="excel-fileinput fileinput fileinput-new" data-provides="fileinput">
    <span class="btn btn-default btn-file">
      <span class="fileinput-new">从Excel导入</span>
      <span class="fileinput-exists">重新上传Excel</span>
      <input type="file" name="file">
    </span>
    <a href="<?= $asset('plugins/shop/files/门店列表.xlsx') ?>" class="btn btn-link">下载范例</a>
  </div>
</form>
<?= $block->end() ?>

<!-- /.page-header -->
<div class="row">
  <div class="col-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">
      <table class="js-shop-table record-table table table-bordered table-hover">
        <thead>
        <tr>
          <th class="t-2"></th>
          <th>名称</th>
          <th>电话</th>
          <th>地址</th>
          <th>启用</th>
          <?php $event->trigger('adminShopList') ?>
          <th>操作</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
      <div class="well">
        <form class="form-inline" role="form">
          <label>
            <input class="ace" type="checkbox" id="check-all">
            <span class="lbl"> 全选 </span>
          </label>

          <div class="form-group">
            <a id="batch-del" class="btn btn-info pull-right" href="javascript:void(0);">批量删除</a>
          </div>
        </form>
      </div>
    </div>
    <!-- /.table-responsive -->
    <!-- PAGE CONTENT ENDS -->
  </div>
  <!-- /col -->
</div>
<!-- /row -->

<?php require $view->getFile('@admin/admin/checkboxCol.php') ?>

<?= $block->js() ?>
<script>
  require(['plugins/admin/js/data-table', plugins/app/libs/artTemplate/template.min, 'form',
    'comps/jasny-bootstrap/dist/js/jasny-bootstrap.min'], function () {
    $('#search-form').loadParams().update(function () {
      recordTable.reload($(this).serialize());
    });

    var recordTable = $('.js-shop-table').dataTable({
      ajax: {
        url: $.queryUrl('admin/shop.json')
      },
      columns: [
        {
          data: 'id',
          sClass: 'text-center',
          render: function (data) {
            return '<label><input type="checkbox" class="js-id ace" value="' + data + '">' +
              '<span class="lbl"></span></label>';
          }
        },
        {
          data: 'name'
        },
        {
          data: 'phone'
        },
        {
          data: 'id',
          render: function (data, type, full) {
            return full.province + full.city + full.address;
          }
        },
        {
          data: 'enable',
          render: function (data, type, full) {
            return template.render('checkbox-col-tpl', {
              id: full.id,
              name: 'enable',
              value: data
            });
          }
        },
        <?php $event->trigger('adminShopListContent') ?>
        {
          data: 'id',
          render: function (data, type, full) {
            return template.render('table-actions', full)
          }
        }
      ]
    });

    recordTable.deletable();

    $('#check-all').click(function () {
      $('.js-id').prop('checked', $(this).is(':checked'));
    });

    //批量删除
    $('#batch-del').click(function () {
      var ids = $('.js-id:checked').map(function () {
        return $(this).val();
      }).get();
      if (ids == '') {
        alert('请选择<?= wei()->shop->shopName ?>');
        return;
      }
      $.confirm('删除之后将无法恢复，确认吗?', function () {
        $.ajax({
          url: $.url('admin/shop/batchDel'),
          data: {ids: ids},
          dataType: 'json'
        }).done(function (data) {
          $.suc(data.message);
          recordTable.reload($(this).serialize());
        });
      });
    });

    var importExcel = {};

    // 上传文件到服务器
    importExcel.uploadFile = function () {
      $('#shop-upload-form').ajaxSubmit({
        dataType: 'json',
        type: 'post',
        data: {cols: 5},
        url: $.url('admin/excel/uploadAndParseToJson'),
        success: function (result) {
          if (result.code < 0) {
            $.err(result.message, 5000);
          } else {
            $.info('文件上传成功,解析中...', 60000);
            $.tips.hideAll();
            $.msg(result);
            if (result.code > 0) {
              importExcel.loadData(result.data);
            }
          }
        }
      });
    };

    // 提交给解析器解析Excel处理
    importExcel.parseExcel = function (file) {
      $.ajax({
        type: 'post',
        url: $.url('admin/excel/parseToJson'),
        data: {
          file: file,
          cols: 5
        },
        dataType: 'json',
        success: function (result) {
          $.tips.hideAll();
          $.msg(result);
          if (result.code > 0) {
            importExcel.loadData(result.data);
          }
        },
        error: function (result) {
          $.tips.hideAll();
          $.msg(result);
        }
      });
    };

    // 将数据填充到表格中
    importExcel.loadData = function (data) {
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: $.url('admin/shop/upload'),
        data: {shops: data},
        success: function (result) {
          window.location.href = '<?=wei()->url('admin/shop/index')?>';
        },
        error: function (result) {
        }
      });
    };

    $('.excel-fileinput').on('change.bs.fileinput', function (event) {
      importExcel.uploadFile();
      $(this).fileinput('clear');
    });

    // 切换状态
    recordTable.on('click', '.toggle-status', function () {
      var $this = $(this);
      var data = {};
      data['id'] = $this.data('id');
      data[$this.attr('name')] = +!$this.data('value');
      $.post($.url('admin/shop/update'), data, function (result) {
        $.msg(result);
        recordTable.reload();
      }, 'json');
    });
  });
</script>
<?= $block->end() ?>

<script id="table-actions" type="text/html">
  <div class="action-buttons">
    <?php if (wei()->shop->enableShopUser) { ?>
      <a href="<%= $.url('admin/shop-users', {id: id}) %>">
        店员管理
      </a>
    <?php } ?>
    <a href="<%= $.url('admin/shop/edit', {id: id}) %>">
      编辑
    </a>
    <a class="text-danger delete-record" data-href="<%= $.url('admin/shop/destroy', {id: id}) %>" href="javascript:">
      删除
    </a>
  </div>
</script>
