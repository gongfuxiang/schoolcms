/**
 * 编辑
 */
$(document).on('click', '.submit-edit', function()
{
	// 父级禁用菜单列表选择
	if($(this).data('is_exist_son') == 'ok')
	{
		$('form select[name="pid"]').attr('disabled', 'disabled');
	} else {
		$('form select[name="pid"]').removeAttr('disabled');
	}
});