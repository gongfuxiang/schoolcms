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
 * 菜单选中
 */
var store = $.AMUI.store;
if(store.enabled != false)
{
	var menu_tag = $('.common-left-menu-active').attr('id');
	if(menu_tag != undefined)
	{
		store.set('common_left_menu_tag', menu_tag);
	} else {
		var tag = store.get('common_left_menu_tag');
		if(tag != undefined)
		{
			// 指定的页默认选中首页
			var all_not = ["Admin_SaveInfo"];
			if(all_not.indexOf($('body').attr('tag')) == -1)
			{
				$('#'+tag).addClass('common-left-menu-active');
			} else {
				$('#common-left-menu-home').addClass('common-left-menu-active');
			}
		}
	}
}
