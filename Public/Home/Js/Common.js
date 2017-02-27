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
});