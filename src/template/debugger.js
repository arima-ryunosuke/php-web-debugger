/**
 * 共通的なものしか記述しない。モジュール個別のものは prepareInner で定義する。
 * php include で読み込まれるので php タグに注意すること。
 */

$(function () {
    var $document = $(document);

    // 子から見た親フレーム
    var self = $('#webdebugger-iframe', window.parent.document);
    var width = self.width();
    var height = self.height();

    // 埋め込まれている変数
    var vars = {};
    var hiddens = $('#js-variable').find('input[type=hidden]');
    for (var i = 0; i < hiddens.length; i++) {
        vars[hiddens.eq(i).attr('name')] = hiddens.eq(i).val();
    }

    // クッキーによるオプション
    var options = {};
    var keyvals = document.cookie.split(';');
    for (var i = 0; i < keyvals.length; i++) {
        var keyval = $.trim(keyvals[i]).split('=');
        if (keyval[0] === 'WebDebuggerOptions') {
            options = JSON.parse(decodeURIComponent(keyval[1]));
            break;
        }
    }
    for (var module in options) {
        if (options[module]) {
            var m = $('.debug_plugin_parts[data-module-class="' + module.replace(/\\/g, '\\\\') + '"]');
            for (var name in options[module]) {
                var input = m.find('[name="' + name + '"]');
                input.is(':radio, :checkbox') ? input.prop('checked', !!options[module][name]) : input.val(options[module][name]);
            }
        }
    }

    $document.delegate('.debug_plugin_setting', 'change', function () {
        var $this = $(this);
        var module = $this.closest('.debug_plugin_parts').data('module-class');
        var name = $this.attr('name');
        var value = $this.is(':radio, :checkbox') ? $this.prop('checked') : $this.val();

        options[module] = options[module] || {};
        options[module][name] = value;

        document.cookie = 'WebDebuggerOptions=' + encodeURIComponent(JSON.stringify(options)) + '; path=/; ';

        // enable は特別扱い
        if (name === 'enable') {
            $('.debug_plugin_parts.' + module).toggleClass('disabled', !value);
        }
    });
    $document.delegate('.debug_plugin_switch', 'mouseover', function () {
        $(this).find('.debug_plugin_title').show();
        self.width('100%');
        self.height('100%');
    });
    $document.delegate('.debug_plugin_switch', 'mouseout', function () {
        $(this).find('.debug_plugin_title').hide();
        if ($(".debug_plugin_wrap:visible").length === 0) {
            self.width(width);
            self.height(height);
        }
    });
    $document.delegate('.debug_plugin_switch', 'click', function () {
        var $this = $(this);
        var target = $this.next(".debug_plugin_wrap");
        $this.parent().siblings().find(".debug_plugin_wrap").not(target).hide();
        $this.next(".debug_plugin_wrap").slideToggle('fast');
    });
    $document.delegate('html,body', 'click', function (e) {
        if ($(e.target).closest('.debug_plugin').length === 0) {
            $(".debug_plugin_wrap:visible").slideUp('fast', function () {
                self.width(width);
                self.height(height);
            });
        }
    });
    $document.delegate('a.holding', 'click', function (e) {
        $(this).toggleClass('opened').next().toggle();
        e.stopPropagation();
    });
    $document.delegate('[data-type="object-index"]', 'click', function () {
        var $this = $(this);
        var id = $this.data('id');
        var pre = $this.closest('pre');
        var objects = pre.find('[data-id=' + id + ']');
        pre.find('.holding.focused').removeClass('focused');
        objects.eq(0).parents('.holdingdiv').show();
        objects.filter('[data-type="object"]').closest('.holdingdiv').prev().addClass('focused')[0].scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
        });
    });
    $document.delegate('a.popup', 'click', function (e) {
        var wrapper = $(this).toggleClass('opened').next(e);
        if (!wrapper.is(':visible')) {
            wrapper.css('left', Math.max(0, (wrapper.closest('.debug_plugin_wrap').width() - wrapper.outerWidth(true)) / 2));
            wrapper.fadeIn('fast');
        }
        else {
            wrapper.fadeOut('fast', function () {
                if (wrapper.is('.removable')) {
                    wrapper.remove();
                }
            });
        }
        e.stopPropagation();
    });
    $document.delegate('a[data-href]', 'click', function () {
        if (vars.opener) {
            $.ajax(vars.opener + $(this).data('href') + '?' + vars.opener_query, {
                xhrFields: {
                    withCredentials: false,
                },
            });
        }
    });
    $document.delegate('table.debug_table thead th', 'click', function () {
        var $this = $(this);
        var table = $this.closest('table.debug_table');
        var tbody = table.children('tbody');
        var ths = table.children('thead').find('th');
        var index = ths.index($this);
        var order = $this.hasClass('asc') ? 'desc' : 'asc';
        ths.removeClass('asc desc');
        $this.addClass(order);

        var sets = [];
        tbody.children('tr').each(function () {
            var tr = $(this);
            var td = tr.children('td:eq(' + index + ')');
            var value = td.text();
            if (td.children('.numeric').length) {
                value = parseFloat(value.replace(/,/g, ''));
            }
            sets.push({
                o: tr,
                v: value,
            });
        });

        var ascdesc = {asc: 1, desc: -1};
        sets.sort(function (a, b) {
            if (a.v > b.v) {
                return ascdesc[order];
            }
            if (a.v < b.v) {
                return -ascdesc[order];
            }
            return 0;
        });
        for (var i = 0; i < sets.length; i++) {
            tbody.append(sets[i].o);
        }
    });
});
