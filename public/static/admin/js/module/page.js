/*
 * @Title: 页面类
 * @Descripttion: 处理页面弹窗开启关闭及页面刷新
 * @version: 1.0.0
 * @Author: wzs
 * @Date: 2020-05-10 11:42:25
 * @LastEditors: wzs
 * @LastEditTime: 2020-06-18 21:36:54
 */
layui.define(['jquery', 'layer'], function (exports) {
    var $ = layui.jquery,
        layer = layui.layer;
    var obj = {
        init: function () {
            // $('body').on('click', '*[lay-href]', function () {
            //     var url = $(this).attr('lay-href')
            //     var title = $(this).attr('lay-title') ? $(this).att('lay-title') : $(this).html()
            //     var index = layer.open({
            //         type: 2,
            //         title: title,
            //         shadeClose: true,
            //         shade: 0.5,
            //         maxmin: true, //开启最大化最小化按钮
            //         area: ['90%', '90%'],
            //         content: url
            //     });
            //     // layer.full(index);
            // })
            // $('body').on('click', '*[lay-close]', function () {
            //     var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            //     parent.layer.close(index); //再执行关闭   
            // })
        },
        reload: function () {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
            parent.layui.table.reload('list');
        }
    };
    //输出接口
    exports('page', obj);
});