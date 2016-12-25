/**
 * 编辑
 */
$(document).on('click', '.submit-edit', function()
{
	// 更改窗口名称
	$title = $('#tree-save-win').find('.am-popup-title');
	$title.text($title.data('edit-title'));
});