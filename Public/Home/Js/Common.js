$(function()
{
	// 回顶部监测
	$(window).scroll(function()
	{
		if($(window).scrollTop() > 100)
		{
			$("#my-go-top").fadeIn(1000);
		} else {
			$("#my-go-top").fadeOut(1000);
		}
	});

	// 用户中心菜单
	$('.user-item-parent').on('click', function()
	{
		$(this).find('.am-icon-angle-down').toggleClass('left-menu-more-ico-rotate');
	});
});