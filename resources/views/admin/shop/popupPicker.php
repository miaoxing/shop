<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/admin/css/filter.css') ?>"/>
<?= $block->end() ?>

<script type="text/html" id="shop-popup-picker-tpl">
  <% if (shops.length !== 0) { %>
    <div class="js-shop-popup-picker-shops shop-popup-picker-shops">
      <% $.each(shops, function(i, shop) { %>
        <p><%= shop.name %></p>
        <input type="hidden" name="<%= inputName %>" value="<%= shop.id %>">
      <% }) %>
    </div>
  <% } %>
  <a href="javascript:;" class="js-shop-popup-picker-select"><%= shops.length === 0 ? selectName : changeName %></a>
  <% if (shops.length !== 0) { %>
    <a href="javascript:;" class="js-shop-popup-picker-clear"><%= clearName %></a>
  <% } %>
</script>

<script type="text/html" id="shop-popup-picker-modal-tpl">
  <div class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">请选择门店</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-a-0">
          <div class="well form-well shop-popup-picker-well">
            <form class="js-shop-popup-picker-form form-inline" role="form">
              省份:
              <div class="form-group">
                <select class="js-cascading-item province form-control" id="province" name="province">
                </select>
              </div>

              城市:
              <div class="form-group">
                <select class="js-cascading-item city form-control" id="city" name="city">
                </select>
              </div>

              <div class="pull-right">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="js-shop-popup-picker-view-selected" name="ids" value=""> 查看已选
                  </label>
                </div>
                <div class="form-group">
                  <p class="form-control-static">
                    已选 <span class="js-shop-popup-picker-selected-num">0</span> 个,
                    可选 <span class="js-shop-popup-picker-max-num">...</span> 个
                  </p>
                </div>
              </div>
            </form>
          </div>

          <table class="js-shop-popup-picker-table shop-popup-picker-table table-center table table-bordered table-hover">
            <thead>
            <tr>
              <th>名称</th>
              <th>电话</th>
              <th>类目</th>
              <th>地址</th>
              <th>状态</th>
              <th>操作</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="js-shop-popup-picker-confirm btn btn-primary" data-dismiss="modal">确定</button>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/html" id="shop-popup-picker-actions-tpl">
  <a href="javascript:;" class="js-shop-popup-picker-toggle btn <%= selected ? 'selected btn-info' : 'btn-default' %>" data-id="<%= id %>"><%= selected ? '取消' : '选择' %></a>
</script>
