define([
  'plugins/admin/js/form',
  'plugins/app/libs/artTemplate/template.min',
  'css!plugins/shop/css/admin/shop-popup-picker',
  'plugins/admin/js/data-table',
  'comps/jquery-cascading/jquery-cascading'
], function (form, template) {
  var ShopPopupPicker = function () {
    // do nothing.
  };

  ShopPopupPicker.DEFAULTS = {
    data: {},
    target: 'body',
    maxNum: 1,
    url: $.url('admin/shop.json'),
    inputName: 'shop_id',
    selectName: '请选择门店',
    changeName: '重新选择',
    clearName: '取消'
  };

  ShopPopupPicker.prototype.render = function (element, options) {
    this.options = $.extend({}, ShopPopupPicker.DEFAULTS, typeof options === 'object' && options);
    this.$element = $(element);

    this.initElements();
    this.renderPicker();
    this.initEvents();
  };

  ShopPopupPicker.prototype.initElements = function () {
    this.$modal = $(template.render('shop-popup-picker-modal-tpl'));
    this.$form = this.$modal.find('.js-shop-popup-picker-form');
    this.$table = this.$modal.find('.js-shop-popup-picker-table');
    this.$viewSelected = this.$modal.find('.js-shop-popup-picker-view-selected');
    this.$selectedNum = this.$modal.find('.js-shop-popup-picker-selected-num');
  };

  ShopPopupPicker.prototype.renderPicker = function () {
    var shops = $.map(this.options.data, function(shop) {
      shop.content = '价格: ' + shop.price + ' 库存: ' + shop.quantity;
      return shop;
    });

    this.$element.html(template.render('shop-popup-picker-tpl', {
      shops: shops,
      selectName: this.options.selectName,
      changeName: this.options.changeName,
      clearName: this.options.clearName,
      inputName: this.options.inputName
    }));

    var e = $.Event('shopPopupPicker:renderPicker', {
      shops: shops
    });
    this.$element.trigger(e);
  };

  ShopPopupPicker.prototype.renderModal = function () {
    if ($.fn.dataTable.fnIsDataTable(this.$table[0])) {
      this.$table.reload();
      return;
    }

    var that = this;
    this.$modal.find('.js-shop-popup-picker-max-num').html(this.options.maxNum);
    this.$modal.appendTo(this.options.target);
    form.toOptions(this.$modal.find('.js-shop-popup-picker-category-id'), this.options.categories, 'id', 'name');

    this.$modal.find('.js-cascading-item').cascading({
      url: $.url('regions.json', {parentId: '中国'}),
      valueKey: 'label'
    });

    this.indexData();
    this.updateSelectedData();

    this.$table = this.$table.dataTable({
      ajax: {
        url: that.options.url
      },
      columns: [
        {
          data: 'name'
        },
        {
          data: 'phone',
          render: function (data) {
            return data || '-';
          }
        },
        {
          data: 'category',
          render: function (data) {
            return data || '-';
          }
        },
        {
          data: 'id',
          render: function (data, type, full) {
            return full.province + full.city + full.address;
          }
        },
        {
          data: 'enable',
          render: function (data) {
            return data === '0' ? '已禁用' : '启用中';
          }
        },
        {
          data: 'id',
          render: function (data, type, full) {
            full.selected = typeof that.options.data[data] !== 'undefined';
            return template.render('shop-popup-picker-actions-tpl', full);
          }
        }
      ]
    });
  };

  ShopPopupPicker.prototype.initEvents = function () {
    var that = this;

    this.$element.on('click', '.js-shop-popup-picker-select', function () {
      that.show();
    });

    this.$element.on('click', '.js-shop-popup-picker-clear', function () {
      that.clear();
    });

    this.$form.update(function () {
      that.$table.reload($(this).serialize(), false);
    });

    // 加入或取消商品
    this.$table.on('click', '.js-shop-popup-picker-toggle', function () {
      var $this = $(this);

      var id = $this.data('id');
      var selected = $this.hasClass('selected');
      var $row = $this.closest('tr');
      var rowData = that.$table.fnGetData($row[0]);

      if (selected) {
        delete that.options.data[id];
      } else {
        if (Object.keys(that.options.data).length >= that.options.maxNum) {
          $.err('最多可选择' + that.options.maxNum + '项');
          return;
        }
        that.options.data[id] = rowData;
      }

      // 重新渲染视图
      that.updateSelectedData();
      $this.parent().html(template.render('shop-popup-picker-actions-tpl', {
        id: id,
        selected: !selected
      }));
    });

    // 关闭选择框,触发关闭事件
    this.$modal.on('hide.bs.modal', function () {
      that.renderPicker();
    });
  };

  // 更改已选数量和id
  ShopPopupPicker.prototype.updateSelectedData = function () {
    var ids = Object.keys(this.options.data);

    var val = '';
    if (ids.length === 0) {
      val = 'not-exists';
    } else {
      val = ids.join(',');
    }
    this.$viewSelected.val(val);
    this.$selectedNum.html(ids.length);
  };

  // 更新数据以id作为索引
  ShopPopupPicker.prototype.indexData = function () {
    var data = {};
    for (var i in this.options.data) {
      if (this.options.data.hasOwnProperty(i)) {
        data[this.options.data[i].id] = this.options.data[i];
      }
    }
    this.options.data = data;
  };

  ShopPopupPicker.prototype.show = function () {
    this.renderModal();
    this.$modal.modal('show');
  };

  ShopPopupPicker.prototype.clear = function () {
    this.options.data = {};
    this.updateSelectedData();
    this.renderPicker();
  };

  return new ShopPopupPicker();
});
