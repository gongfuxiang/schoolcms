// 模块窗口
$layout_module = $('#layout-module-win');
$(function()
{
	// 布局-拖拽-初始化
	$(".layout-content").dragsort({
		dragSelector: ".drag-submit",
		dragEnd: function()
		{
			var data = $(".layout-content .drag-submit").map(function() { return $(this).parents('.layout-view').attr('layout-id'); }).get();
			$("input[name=layout_sort]").val(data.join(";"));
		},
		placeHolderTemplate: "<div class='layout-view-drag'></div>"
	});

	// 模块-添加
	$(document).on('click', '.layout-submit-add', function()
	{
		var url = $('.layout-content').data('module-add-url');
		var tag = $(this).data('tag');
		var id = $(this).data('id');
		var value = $(this).data('value');
		var html = $(this).data('html');
		if(url != undefined && tag != undefined && value != undefined && id != undefined && html != undefined)
		{
			// ajax请求
			$.ajax({
				url:url,
				type:'POST',
				dataType:"json",
				timeout:10000,
				data:{"id":id},
				success:function(result)
				{
					if(result.code == 0)
					{
						// 数据替换-添加
						html = html.replace(/{data-id}/g, result.data);
						html = html.replace(/{data-value}/g, value);
						html = html.replace(/{content-id}/g, 'layout-content-'+value+'-'+id+'-'+result.data);
						html = html.replace(/{layout-module-win}/g, "'#layout-module-win'");
						$('#'+tag).append(html);
					} else {
						Prompt(result.msg);
					}
				}
			});
		} else {
			Prompt('模块配置参数有误');
		}
	});

	// 模块-编辑
	$(document).on('click', '.layout-submit-edit', function()
	{
		$layout_module.attr('data-tag', $(this).data('tag'));
		$layout_module.find('input[name="id"]').val($(this).data('id'));
		$layout_module.find('input[name="layout_value"]').val($(this).data('value'));
	});

	// 布局-移除
	$(document).on('click', '.layout-submit-remove', function()
	{
		// ajax数据库删除
		console.log($(this).data('id'));

		// 移除元素
		$(this).parent().parent().remove();
	});

	// 布局-添加
	$('.layout-list').on('click', 'button', function()
	{
		var url = $('.layout-content').data('layout-url');
		var type = $('.layout-content').data('type');
		var value = $(this).data('value');
		var html = $(this).data('html');
		var html_item = $(this).data('html-item');
		if(url != undefined && type != undefined && value != undefined && html != undefined)
		{
			// ajax请求
			$.ajax({
				url:url,
				type:'POST',
				dataType:"json",
				timeout:10000,
				data:{"type":type, "value":value},
				success:function(result)
				{
					if(result.code == 0)
					{
						// 数据替换-添加
						html = html.replace(/{layout-id}/g, result.data.layout_id)
						html = html.replace(/{data-id}/g, result.data.module_id);
						html = html.replace(/{data-value}/g, value);
						html = html.replace(/{content-id}/g, 'layout-content-'+value+'-'+result.data.module_id);
						html = html.replace(/{layout-module-win}/g, "'#layout-module-win'");
						if(html_item != undefined)
						{
							html = html.replace('{data-html-item}', "data-html='"+html_item+"'");
						}
						$('.layout-content').prepend(html);

						// 动画处理
						setTimeout(function()
						{
							var $first_child = $(".layout-content").children("div:first-child");
							$first_child.css('opacity', 0);
							$first_child.animate({opacity:1}, 500);
						}, 1);
					} else {
						Prompt(result.msg);
					}
				}
			});
		} else {
			Prompt('布局配置参数有误');
		}
		/*var html = $(this).data('html');
		if(html != undefined)
		{
			$('.layout-content').prepend(html);
			setTimeout(function()
			{
				var $first_child = $(".layout-content").children("div:first-child");
				$first_child.css('opacity', 0);
				$first_child.animate({opacity:1}, 500);
			}, 1);
		}*/
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
	$('#'+$layout_module.attr('data-tag')).html(html);
}