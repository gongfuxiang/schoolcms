$(function()
{
	// 全屏操作
	$('#admin-fullscreen').on('click', function()
	{
		$.AMUI.fullscreen.toggle();
	});
	$(document).on($.AMUI.fullscreen.raw.fullscreenchange, function()
	{
		$tag = $('.admin-fulltext');
		$tag.text($.AMUI.fullscreen.isFullscreen ? $tag.attr('fulltext-exit') : $tag.attr('fulltext-open'));
	});
});