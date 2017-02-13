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