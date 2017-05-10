/**
 * 安全提示信息
 */
console.log("%c\u5b89\u5168\u8b66\u544a\uff01","font-size:50px;color:red;-webkit-text-fill-color:red;-webkit-text-stroke: 1px black;");
console.log("%c\u6b64\u6d4f\u89c8\u5668\u529f\u80fd\u4e13\u4f9b\u5f00\u53d1\u8005\u4f7f\u7528\u3002\u8bf7\u4e0d\u8981\u5728\u6b64\u7c98\u8d34\u6267\u884c\u4efb\u4f55\u5185\u5bb9\uff0c\u8fd9\u53ef\u80fd\u4f1a\u5bfc\u81f4\u60a8\u7684\u8d26\u6237\u53d7\u5230\u653b\u51fb\uff0c\u7ed9\u60a8\u5e26\u6765\u635f\u5931 \uff01","font-size: 20px;color:#333");
console.log("\u611f\u8c22\u4f7f\u7528\u0053\u0063\u0068\u006f\u006f\u006c\u0043\u004d\u0053\u6559\u52a1\u7ba1\u7406\u7cfb\u7edf\uff0c\u5b98\u65b9\u5730\u5740\uff1a\u0068\u0074\u0074\u0070\u003a\u002f\u002f\u0073\u0063\u0068\u006f\u006f\u006c\u0063\u006d\u0073\u002e\u006f\u0072\u0067\u002f");

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