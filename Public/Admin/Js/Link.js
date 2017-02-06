/**
 * 添加
 */
$('.submit-add').on('click', function()
{
	// 清空表单
	FormDataFill({"id":"", "name":"", "url":"", "describe":"", "sort":0, "is_enable":1});

	// 校验成功状态增加失去焦点
	$('form.form-validation').find('.am-field-valid').each(function()
	{
		$(this).blur();
	});
});