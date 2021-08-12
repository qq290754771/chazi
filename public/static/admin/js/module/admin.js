/*
 * @Title: 
 * @Descripttion: 
 * @version: 
 * @Author: wzs
 * @Date: 2020-06-17 21:27:07
 * @LastEditors: wzs
 * @LastEditTime: 2020-08-02 13:53:07
 */
layui.define(['jquery', 'element', 'layer', 'pjax', 'nicescroll'], function (exports) {
    "use strict";
    var $ = layui.jquery,
        element = layui.element,
        layer = layui.layer,
        pjax = layui.pjax,
        nicescroll = layui.nicescroll;

    var Admin = function () {
        this.config = {};
        this.v = '1.0.0';
    };

    Admin.prototype.set = function (options) {
        var that = this;
        that.config.data = undefined;
        $.extend(true, that.config, options);
        return that;
    };
    Admin.prototype.sideFlexible = function () {
        $('body').off('click', '[layadmin-event="flexible"]').on('click', '[layadmin-event="flexible"]', function () {
            $('#LAY_app').toggleClass('layadmin-side-shrink')
            $('.layui-nav-item').removeClass('layui-nav-itemed')
        })
        $('body').off('click', '.layadmin-side-shrink .lay' +
            '' +
            '' +
            'ui-side .layui-nav-item').on('click', '.layadmin-side-shrink .layui-side .layui-nav-item', function () {
            $('#LAY_app').toggleClass('layadmin-side-shrink')
            $('.layui-nav-item').removeClass('layui-nav-itemed')
        })
    };
    Admin.prototype.clearCache = function () {
        $('body').off('click', '[layadmin-event="refresh"]').on('click', '[layadmin-event="refresh"]', function () {
            var url = $(this).data('url');
            $.post(url, {}, function (data) {
                layer.msg(data.info, {
                    icon: 6
                }, function (index) {
                    location.reload(!0)
                });
            });
        })
    };
    Admin.prototype.tip = function () {
        $('body').off("mouseenter", "*[lay-tips]").on("mouseenter", "*[lay-tips]", function () {
            var e = $(this);
            if (!e.parent().hasClass("layui-nav-item") || $('#LAY_app').hasClass('layadmin-side-shrink')) {
                var i = e.attr("lay-tips"),
                    t = e.attr("lay-offset"),
                    l = e.attr("lay-direction"),
                    n = layer.tips(i, this, {
                        tips: l || 1,
                        time: -1,
                        success: function (e, a) {
                            t && e.css("margin-left", t + "px")
                        }
                    });
                e.data("index", n)
            }
        }).on("mouseleave", "*[lay-tips]", function () {
            layer.close($(this).data("index"))
        });
    };
    Admin.prototype.router = function () {
        var that = this;
        $(document).on('click', 'a[lay-href]', function (event) {
            var href = window.location.href;
            event.preventDefault();
            var url = $(this).attr('lay-href');
            console.log(url);
            $.pjax({
                url,
                container: '#LAY_app_body',
                fragment: '#LAY_app_body',
                timeout: 8000,
                scrollTo: false
            });
        })

        $(document).off('pjax:start').on('pjax:start', (xhr, options) => {
            // console.log(xhr)
        })

        $(document).off('pjax:end').on('ready pjax:end', (data, options) => {
            // that.scroll()
        })
    };
    Admin.prototype.pop = function () {
        $('body').on('click', 'a[pop-href]', function (event) {
            var url = $(this).attr('pop-href');
            var title = $(this).attr('lay-title') ? $(this).att('lay-title') : $(this).html();
            var index = layer.open({
                type: 2,
                title: title,
                shadeClose: true,
                shade: 0.5,
                maxmin: true, //开启最大化最小化按钮
                area: ['80%', '90%'],
                content: url
            });
        })
        $('body').on('click', '*[lay-close]', function () {
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            parent.layer.close(index); //再执行关闭   
        })
    }
    Admin.prototype.formReload = function () {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
        parent.tableIn.reload('list');
        
    }
    Admin.prototype.scroll = function () {
        $('#LAY_app_body').niceScroll({
            cursorcolor: '#499bfc',
            zindex: 10
        })
    }
    Admin.prototype.init = function () {  
        $('#LAY_app_body').getNiceScroll().resize();
    }
    Admin.prototype.initPage = function () {
        var that = this;
        that.sideFlexible()
        that.tip()
        that.router()
        that.pop()
        that.clearCache()
        that.scroll()

    };

    var admin = new Admin();
    exports('admin', function (options) {
        return admin.set(options);
    });
});