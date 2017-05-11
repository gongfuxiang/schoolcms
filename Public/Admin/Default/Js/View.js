// 模块窗口
$layout_module = $('#layout-module-win');
$layout_content = $('.layout-content');
$(function()
{
	// 布局-拖拽-初始化
	$(".layout-content").dragsort(
	{
		dragSelector: ".drag-submit",
		dragEnd: function()
		{
			var data = $(".layout-content .drag-submit").map(function() { return $(this).parents('.layout-view').data('layout-id'); }).get();
			// ajax请求
			$.ajax({
				url:$layout_content.data('layout-sort-save-url'),
				type:'POST',
				dataType:"json",
				timeout:10000,
				data:{"data":data},
				success:function(result)
				{
					if(result.code == 0)
					{
						Prompt(result.msg, 'success');
					} else {
						Prompt(result.msg);
					}
				},
				error:function()
				{
					Prompt('网络异常错误');
				}
			});
		},
		placeHolderTemplate: "<div class='layout-view-drag'></div>"
	});

	// 模块-添加
	$(document).on('click', '.layout-submit-add', function()
	{
		var url = $layout_content.data('module-add-url');
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
						html = html.replace(/{data-module-id}/g, result.data);
						html = html.replace(/{data-value}/g, value);
						html = html.replace(/{content-module-id}/g, 'layout-content-'+value+'-'+result.data);
						html = html.replace(/{layout-module-win}/g, "'#layout-module-win'");
						$('#'+tag).append(html);
					} else {
						Prompt(result.msg);
					}
				},
				error:function()
				{
					Prompt('网络异常错误');
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
		FormDataFill(eval('('+$(this).attr('data-json')+')'), '#layout-module-win');
	});

	// [布局-模块]-删除
	$(document).on('click', '.layout-submit-delete', function()
	{
		// ajax数据库删除
		var id = $(this).data('id');
		var type = $(this).data('type');

		if(id != undefined && type != undefined)
		{
			var $this = $(this);
			$.ajax({
				url:$layout_content.data(type+'-delete-url'),
				type:'POST',
				dataType:"json",
				timeout:10000,
				data:{"id":id},
				success:function(result)
				{
					if(result.code == 0)
					{
						// 移除元素
						$this.parent().parent().remove();

						Prompt(result.msg, 'success');
					} else {
						Prompt(result.msg);
					}
				},
				error:function()
				{
					Prompt('网络异常错误');
				}
			});
		} else {
			Prompt('布局配置参数有误');
		}
	});

	// 布局-添加
	$('.layout-list').on('click', 'button', function()
	{
		var url = $layout_content.data('layout-save-url');
		var type = $layout_content.data('type');
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
						html = html.replace(/{data-layout-id}/g, result.data.layout_id)
						html = html.replace(/{data-value}/g, value);
						html = html.replace(/{layout-module-win}/g, "'#layout-module-win'");
						
						// 布局是否带模块
						if(result.data.module_count > 0)
						{
							for(var i=1; i<=result.data.module_count; i++)
							{
								var temp_field = 'module'+i+'_id';
								if(result.data[temp_field] != undefined)
								{
									html = html.replace(new RegExp('{data-module'+i+'-id}','g'), result.data[temp_field]);
									html = html.replace(new RegExp('{content-module'+i+'-id}','g'), 'layout-content-'+value+'-'+result.data[temp_field]);
								}
							}
						} else {
							html = html.replace(/{data-module-id}/g, result.data.layout_id);
							html = html.replace(/{content-module-id}/g, 'layout-content-'+value+'-'+result.data.layout_id);
						}

						// 是否存在子html
						if(html_item != undefined)
						{
							html = html.replace('{data-html-item}', "data-html='"+html_item+"'");
						}

						// 添加到页面中
						$layout_content.prepend(html);

						// 布局开关操作初始化
						LayoutSwitchInit();

						// 动画处理
						setTimeout(function()
						{
							var $first_child = $(".layout-content").children("div:first-child");
							$first_child.css('opacity', 0);
							$first_child.animate({opacity:1}, 500);
						}, 1);
						Prompt(result.msg, 'success');
					} else {
						Prompt(result.msg);
					}
				},
				error:function()
				{
					Prompt('网络异常错误');
				}
			});
		} else {
			Prompt('布局配置参数有误');
		}
	});

	// 数据导入form初始化
	FromInit('form.form-validation-layout-import');

	// 模板上传选择名称展示
	$('#layout-import-win input[name="file"]').on('change', function()
	{
		var fileNames = '';
		$.each(this.files, function()
		{
			fileNames += '<span class="am-badge">' + this.name + '</span> ';
		});
		$('#form-file-tips').html(fileNames);
	});
});


/**
 * [LayoutSwitchInit 布局开关插件初始化]
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2017-02-21T15:25:12+0800
 */
function LayoutSwitchInit()
{
	$('[name="switch-checkbox"]').bootstrapSwitch(
	{
		onSwitchChange: function(event, state)
		{
			var $this = $(this);
			var state_text = (state == true) ? $(this).data('on-text') : $(this).data('off-text');
			state = (state == true) ? 1 : 0;
			$.ajax({
				url:$layout_content.data('layout-state-url'),
				type:'POST',
				dataType:"json",
				timeout:10000,
				data:{"id":$(this).data('id'), "state":state},
				success:function(result)
				{
					if(result.code == 0)
					{
						if(state == 1)
						{
							$this.parents('.layout-view').removeClass('layout-view-hidden');
						} else {
							$this.parents('.layout-view').addClass('layout-view-hidden');
						}
						Prompt('[ '+state_text+' ] '+result.msg, 'success');
					} else {
						Prompt('[ '+state_text+' ] '+result.msg);
					}
				},
				error:function()
				{
					Prompt('网络异常错误');
				}
			});
		}
	});
}
LayoutSwitchInit();