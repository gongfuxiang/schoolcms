$(function()
{
	// 模块窗口
	//$layout_module = $('#layout-module-win');

	// 布局-拖拽-初始化
	$(".layout-content").dragsort({
		dragSelector: ".drag-submit",
		dragEnd: function()
		{
			var data = $(".layout-content .drag-submit").map(function() { return $(this).parent().data('id')+'|'+$(this).parent().data('tag'); }).get();
			$("input[name=layout_sort]").val(data.join(";"));
		},
		placeHolderTemplate: "<div class='layout-view-drag'></div>"
	});

	// 布局-编辑
	$(document).on('click', '.layout-submit-edit', function()
	{
		//$layout_module.attr('data-tag', $(this).data('tag'));
	});

	// 布局-移除
	$(document).on('click', '.layout-submit-remove', function()
	{
		$(this).parents('.layout-view').remove();
	});

	// 布局添加
	$('.layout-list').on('click', 'button', function()
	{
		var html = $(this).data('html');
		if(html != undefined)
		{
			$('.layout-content').prepend(html);
			setTimeout(function()
			{
				var $first_child = $(".layout-content").children("div:first-child");
				$first_child.css('opacity', 0);
				$first_child.animate({opacity:1}, 500);
			}, 1);
		}
	});

});


/**
 * [View_Article_Title 视图-标题]
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2017-02-16T19:20:22+0800
 * @param    {[object]}     data [数据列表对象]
 */
function View_Article_Title(data)
{
	// 初始化
	var html = '';

	// 标题
	if(data.name.length > 0 || data.right_title.length > 0)
	{
		html += '<div class="am-list-news-hd am-cf">';
		if(data.name.length > 0)
		{
			html += '<h2>'+data.name+'</h2>';
		}
		if(data.right_title.length > 0)
		{
			if(data.right_title[0] != undefined)
			{
				if(data.right_title[1] == undefined)
				{
					html += '<span class="am-list-news-more am-fr">'+data.right_title[0]+'</span>';
				} else {
					html += '<a href="'+data.right_title[1]+'" target="_blank"><span class="am-list-news-more am-fr">'+data.right_title[0]+'</span></a>';
				}
			}
		}
		html += '</div>';
	}

	// 列表
	html += '<div class="am-list-news-bd"><ul class="am-list">';
	for(var i in data.data)
	{
		// 打开方式
		var blank = (data.link_open_way == 'blank') ? 'target="_blank"' : '';

		// 标题颜色
		var title_color = (data.data[i]['title_color'].length > 0) ? 'style="color:'+data.data[i]['title_color']+';"' : '';

		// 内容
		html += '<li><a href="'+data.data[i]['url']+'" '+blank+' title="'+data.data[i]['title']+'" class="am-text-truncate" '+title_color+'>'+data.data[i]['title']+'</a></li>';
	}
	html += '</ul></div>';
	$('#hahahahahaha').html(html);
	console.log(html);
}