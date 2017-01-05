/**
 * 全屏操作
 */
$('#admin-fullscreen').on('click', function()
{
	$.AMUI.fullscreen.toggle();
});
$(document).on($.AMUI.fullscreen.raw.fullscreenchange, function()
{
	$tag = $('.admin-fulltext');
	$tag.text($.AMUI.fullscreen.isFullscreen ? $tag.attr('fulltext-exit') : $tag.attr('fulltext-open'));
});

/**
 * url加载
 */
$('.common-left-menu').find('li a').on('click', function(){  
    var link = $(this).data('url');
    if(link != undefined)
    {
        $('#ifcontent').attr('src', link);
    } else {
    	if($(this).find('i').length > 0)
    	{
    		/*if($(this).find('i').hasClass('am-icon-angle-down'))
    		{
    			$(this).find('i').removeClass('am-icon-angle-down');
    			$(this).find('i').addClass('am-icon-angle-right');
    		} else {
    			$(this).find('i').removeClass('am-icon-angle-right');
    			$(this).find('i').addClass('am-icon-angle-down');
    		}*/
    		$(this).find('i').toggleClass('left-menu-more-ico-rotate');
    	}
    }
});

/**
 * 菜单选择
 */
$('.common-left-menu li a').on('click', function()
{
    $('.common-left-menu a').removeClass('common-left-menu-active');
    $(this).addClass('common-left-menu-active');
    $('#admin-offcanvas').offCanvas('close');
});