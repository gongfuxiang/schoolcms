/**
 * [Prompt 公共提示]
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-10T14:32:39+0800
 * @param {[string]}	msg  [提示信息]
 * @param {[string]} 	type [类型（失败：danger, 成功success）]
 * @param {[int]} 		time [自动关闭时间（秒）, 默认3秒]
 */
function Prompt(msg, type, time)
{
	if(msg != undefined && msg != '')
	{
		// 先移除已有的提示信息
		$('#common-prompt').remove();

		if(type == undefined || type == '') type = 'danger';
		var html = '<div id="common-prompt" class="am-alert am-alert-'+type+' am-animation-shake" data-am-alert><button type="button" class="am-close am-close-spin">&times;</button><p>'+msg+'</p></div>';
		$('body').append(html);

		// 关闭提示
		if(time == undefined || time == '') time = 3;
		setTimeout(function()
		{
			$('#common-prompt').remove();
		}, time*1000);
	}
}

/**
 * [ArrayTurnJson js数组转json]
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-10T14:32:04+0800
 * @param  {[array]} 	all    	[需要被转的数组]
 * @param  {[object]} 	object 	[需要压进去的json对象]
 * @return {[object]} 			[josn对象]
 */
function ArrayTurnJson(all, object)
{
	for(var name in all)
	{
		var tmp_index = 0;
		for(var index in all[name])
		{
			if(typeof(object[name]) != "object") object[name] = {};
			object[name][tmp_index] = all[name][index];
			tmp_index++;
		}
	}
	return object;
}

/**
 * [GetFormVal 获取form表单的数据]
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-10T14:31:19+0800
 * @param    {[string]}     element [元素的class或id]
 * @return   {[object]}        		[josn对象]
 */
function GetFormVal(element)
{
	var object = {};

	// input 常用类型
	$(element).find('input[type="hidden"], input[type="text"], input[type="password"], input[type="email"], input[type="number"], input[type="date"], input[type="radio"]:checked, textarea').each(function(key, tmp)
	{
		object[tmp.name] = tmp.value;
	});

	// select 单选择和多选择
	var tmp_all = [];
	var i = 0;
	$(element).find('select option:selected').each(function(key, tmp)
	{
		// 单选择
		var name = $(this).parent().attr('name');
		if(name != undefined && name != '')
		{
			object[name] = tmp.value;

			// 多选择
			if($(this).parent().attr('multiple') != undefined)
			{
				if(tmp_all[name] == undefined) tmp_all[name] = [];
				tmp_all[name][i] = tmp.value;
				i++;
			}
		}
	});
	object = ArrayTurnJson(tmp_all, object);

	// input 复选框checkboox
	tmp_all = [];
	i = 0;
	$(element).find('input[type="checkbox"]:checked').each(function(key, tmp)
	{
		if(tmp.name != undefined && tmp.name != '')
		{
			if(tmp_all[tmp.name] == undefined) tmp_all[tmp.name] = [];
			tmp_all[tmp.name][i] = tmp.value;
			i++;
		}
	});
	object = ArrayTurnJson(tmp_all, object);
	return object;
}

/**
 * [IsExitsFunction 方法是否已定义]
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-10T14:30:37+0800
 * @param    {[string]}    fun_name [方法名]
 * @return 	 {[boolean]}        	[已定义true, 则false]
 */
function IsExitsFunction(fun_name)
{
    try {
        if(typeof(eval(fun_name)) == "function") return true;
    } catch(e) {}
    return false;
}

/**
 * [$form.validator 公共表单校验, 添加class form-validation 类的表单自动校验]
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-10T14:22:39+0800
 * @param    {[string] [action] 		[请求地址]}
 * @param    {[string] [method] 		[请求类型 POST, GET]}
 * @param    {[string] [request-type] 	[回调类型 ajax-url, ajax-fun, ajax-reload]}
 * @param    {[string] [request-value] 	[回调值 ajax-url地址 或 ajax-fun方法]}
 */
var form_name = 'form.form-validation';
var $form = $(form_name);
$form.validator(
{
	onInValid: function(validity)
	{
		var $field = $(validity.field);
		var msg = $field.data('validationMessage') || this.getValidationMessage(validity);
		Prompt(msg);

	},
	submit: function()
	{
		if(this.isFormValid())
		{
			// button加载
			var $button = $form.find('button[type="submit"]');
			$button.button('loading');

			// 开启进度条
			$.AMUI.progress.start();

			// 获取表单数据
			var action = $form.attr('action');
			var method = $form.attr('method');
			var request_type = $form.attr('request-type');
			var request_value = $form.attr('request-value');
			var ajax_all = ['ajax-reload', 'ajax-url', 'ajax-fun'];

			// 参数校验
			if(ajax_all.indexOf(request_type) == -1 || action == undefined || action == '' || method == undefined || method == '')
			{
				$.AMUI.progress.done();
            	$button.button('reset');
            	Prompt('表单参数配置有误');
            	return false;
			}

			// 类型不等于刷新的时候，类型值必须填写
			if(request_type != 'ajax-reload' && (request_value == undefined || request_value == ''))
			{
				$.AMUI.progress.done();
        		$button.button('reset');
				Prompt('表单[类型值]参数配置有误');
				return false;
			}

			// ajax请求
			$.ajax({
				url:action,
				type:method,
                dataType:"json",
                timeout:10000,
                data:GetFormVal(form_name),
                success:function(result)
                {
                	// 调用自定义回调方法
                	if(request_type == 'ajax-fun')
                	{
                		if(IsExitsFunction(request_value))
                		{
                			window[request_value](result);
                		} else {
                			$.AMUI.progress.done();
	            			$button.button('reset');
                			Prompt('表单定义的方法未定义');
                		}
                	} else if(request_type == 'ajax-url' || request_type == 'ajax-reload')
                	{
                		$.AMUI.progress.done();
	            		if(result.code == 0)
	            		{
	            			// url跳转
	            			if(request_type == 'ajax-url')
	            			{
	            				window.location.href = request_value;

	            			// 页面刷新
	            			} else if(request_type == 'ajax-reload')
	            			{
	            				Prompt(result.msg, 'success');
	            				setTimeout(function()
								{
									window.location.reload();
								}, 1500);
								}
							} else {
								Prompt(result.msg);
								$button.button('reset');
							}
					}
				},
				error:function(xhr, type)
	            {
	            	$.AMUI.progress.done();
	            	$button.button('reset');
	            	Prompt('请求出错');
	            }
            });
		}
		return false;
	}
});

// 表单数据填充
function FormDataFill(json)
{
	if(json != undefined)
	{
		for(var i in json)
		{
			$form.find('*[name="'+i+'"]').val(json[i]);
		}
	}
}

// 公共数据操作
$(function()
{
	/**
	 * [submit-delete 删除数据列表]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T14:22:39+0800
	 * @param    {[int] 	[data-id] 	[数据id]}
	 * @param    {[string] 	[data-url] 	[请求地址]}
	 */
	$('.submit-delete').on('click', function()
	{
		$('#common-confirm-delete').modal({
			relatedTarget: this,
			onConfirm: function(options)
			{
				// 获取参数
				var $tag = $(this.relatedTarget);
				var id = $tag.data('id');
				var url = $tag.data('url');
				if(id == undefined || url == undefined)
				{
					Prompt('参数配置有误');
					return false;
				}

				// 请求删除数据
				$.ajax({
					url:url,
					type:'POST',
					dataType:"json",
					timeout:10000,
					data:{"id":id},
					success:function(result)
					{
						if(result.code == 0)
						{
							Prompt(result.msg, 'success');

							// 成功则删除数据列表
							$('#admin-data-list-'+id).remove();
						} else {
							Prompt(result.msg);
						}
					},
					error:function(xhr, type)
					{
						Prompt('异常出错');
					}
				});
			},
			onCancel: function(){}
		});
	});

	/**
	 * [submit-edit 公共编辑]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T13:53:13+0800
	 * @param    {[type]}                 )	{		var json          [description]
	 * @return   {[type]}                           [description]
	 */
	$('.submit-edit').on('click', function()
	{
		FormDataFill($(this).data('json'));
	});
});