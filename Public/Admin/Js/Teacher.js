$(function()
{
	/* 搜索切换 */
	var $more_where = $('.more-where');
	$more_submit = $('.more-submit');
	$more_submit.find('input[name="is_more"]').change(function()
	{
		if($more_submit.find('i').hasClass('am-icon-angle-down'))
		{
			$more_submit.find('i').removeClass('am-icon-angle-down');
			$more_submit.find('i').addClass('am-icon-angle-up');
		} else {
			$more_submit.find('i').addClass('am-icon-angle-down');
			$more_submit.find('i').removeClass('am-icon-angle-up');
		}
	
		if($more_submit.find('input[name="is_more"]:checked').val() == undefined)
		{
			$more_where.addClass('none');
		} else {
			$more_where.removeClass('none');
		}
	});
});