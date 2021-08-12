layui.define(function(e) {
	layui.use(['admin', 'carousel'], function() {
		var e = layui.$,
			t = (layui.admin, layui.carousel),
			a = layui.element,
			i = layui.device()
		e('.layadmin-carousel').each(function() {
			var a = e(this)
			t.render({
				elem: this,
				width: '100%',
				arrow: 'none',
				interval: a.data('interval'),
				autoplay: a.data('autoplay') === !0,
				trigger: i.ios || i.android ? 'click' : 'hover',
				anim: a.data('anim')
			})
		}),
			a.render('progress')
	})
	layui.use(['carousel', 'echarts'], function() {
		var e = layui.$
		e.get(
			'/admin/index/getpv',
			function(data, textStatus, xhr) {
				if (data) {
					var t = layui.carousel,
            a = layui.echarts,
            i = [],
            l = [
              {
                title: {
                  text: "",
                  x: "center",
                  textStyle: {
                    fontSize: 14,
                  },
                },
                tooltip: {
                  trigger: "axis",
                },
                legend: {
                  data: ["销量", "销售额"],
                },
                xAxis: [
                  {
                    type: "category",
                    // boundaryGap: false,
                    data: data.riqistr,
                  },
                ],
                yAxis: [
                  {
                    type: "value",
                  },
                ],
                series: [
                  {
                    name: "销量",
                    type: "bar",
                    barMaxWidth: 20,
                    data: data.pvstr,
                  },
                  {
                    name: "销售额",
                    type: "bar",
                    barMaxWidth: 20,
                    data: data.uvstr,
                  },
                ],
              },
            ],
            n = e("#LAY-index-dataview").children("div"),
            r = function (e) {
              (i[e] = a.init(n[e], layui.echartsTheme)),
                i[e].setOption(l[e]),
                (window.onresize = i[e].resize);
            };
					if (n[0]) {
						r(0)
						var o = 0
						t.on('change(LAY-index-dataview)', function(e) {
							r((o = e.index))
						}),
							layui.admin.on('side', function() {
								setTimeout(function() {
									r(o)
								}, 300)
							}),
							layui.admin.on('hash(tab)', function() {
								layui.router().path.join('') || r(o)
							})
					}
				}
			},
			'json'
		)
	})
	layui.use('table', function() {
		var e = (layui.$, layui.table)
		setTimeout(function() {
			e.render({
				elem: '#LAY-index-topSearch',
				url: '/admin/index/getrank',
				cellMinWidth: 80,
				page: !0,
				cols: [
					[
						{
							type: 'numbers',
							title: '编号'
						},
						{
							field: 'username',
							title: '姓名'
						},
						{
							field: 'points',
							title: '积分',
							sort: !0
						},
						{
							field: 'addtime',
							title: '答题时间'
						}
					]
				],
				skin: 'line'
			})
			e.render({
				elem: '#LAY-index-topCard',
				url: '/admin/index/gettotalrank',
				cellMinWidth: 80,
				method: 'post',
				page: true,
				cols: [
					[
						{
							type: 'numbers',
							title: '编号'
						},
						{
							field: 'username',
							title: '姓名'
						},
						{
							field: 'points',
							title: '积分',
							sort: !0
						}
					]
				],
				skin: 'line'
			})
		}, 200)
	}),
		layui.use('element', function() {
			var $ = layui.jquery,
				element = layui.element //Tab的切换功能，切换事件监听等，需要依赖element模块

			$.get(
				'/admin/index/getsysinfo/type/cpu',
				function(data, textStatus, xhr) {
					if (data) {
						setTimeout(function() {
							element.progress('demo', data.cpu + '%')
							element.progress('demo2', data.memory + '%')
							// element.render('progress');
						}, 500)
					}
				},
				'json'
			)
		})
	e('console', {})
})
