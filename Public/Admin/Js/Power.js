$(function()
{
	// 展开/关闭
	$('.tree-list i').on('click', function()
	{
		if($(this).hasClass('am-icon-plus'))
		{
			$(this).removeClass('am-icon-plus');
			$(this).addClass('am-icon-minus-square');
		} else {
			$(this).removeClass('am-icon-minus-square');
			$(this).addClass('am-icon-plus');
		}
		$(this).siblings('.list-find').toggle(100);
	});

	// 全选/取消
	$('.node-choice').on('click', function()
	{
		var state = $(this).is(':checked');
		$(this).parent().siblings('.list-find').find('input[type="checkbox"]').each(function()
		{  
			this.checked = state;
		});
	});
	// 子元素选择/取消操作
	$('.list-find input[type="checkbox"]').on('click', function()
	{
		var state = ($(this).parents('.list-find').find('input[type="checkbox"]:checked').length > 0);
		$(this).parents('ul').siblings('label').find('input').each(function()
		{  
			this.checked = state;
		});
	});
});