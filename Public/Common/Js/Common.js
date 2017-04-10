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
var temp_time_out;
function Prompt(msg, type, time)
{
	if(msg != undefined && msg != '')
	{
		// 是否已存在提示条
		if($('#common-prompt').length > 0)
		{
			clearTimeout(temp_time_out);
		}

		// 提示信息添加
		$('#common-prompt').remove();
		if(type == undefined || type == '') type = 'danger';
		var html = '<div id="common-prompt" class="am-alert am-alert-'+type+' am-animation-shake" data-am-alert><button type="button" class="am-close am-close-spin">&times;</button><p>'+msg+'</p></div>';
		$('body').append(html);

		// 自动关闭提示
		if(time == undefined || time == '') time = 3;
		temp_time_out = setTimeout(function()
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
		object.append(name, all[name]);
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
	var object = new FormData();

	// input 常用类型
	$(element).find('input[type="hidden"], input[type="text"], input[type="password"], input[type="email"], input[type="number"], input[type="date"], input[type="url"], input[type="radio"]:checked, textarea, input[type="file"]').each(function(key, tmp)
	{
		if(tmp.type == 'file')
		{
			object.append(tmp.name, ($(this).get(0).files[0] == undefined) ? '' : $(this).get(0).files[0]);
		} else {
			object.append(tmp.name, tmp.value.replace(/^\s+|\s+$/g,""));
		}
	});

	// select 单选择和多选择
	var tmp_all = [];
	var i = 0;
	$(element).find('select').find('option, optgroup option').each(function(key, tmp)
	{
		var name = $(this).parents('select').attr('name');
		if(name != undefined && name != '')
		{
			if($(this).is(':selected'))
			{
				// 多选择
				if($(this).parent().attr('multiple') != undefined)
				{
					if(tmp_all[name] == undefined) tmp_all[name] = [];
					tmp_all[name][i] = tmp.value;
					i++;
				} else {
					// 单选择
					object.append(name, tmp.value);
				}
			}
		}
	});
	object = ArrayTurnJson(tmp_all, object);

	// input 复选框checkboox
	tmp_all = [];
	i = 0;
	$(element).find('input[type="checkbox"]').each(function(key, tmp)
	{
		if(tmp.name != undefined && tmp.name != '')
		{
			if($(this).is(':checked'))
			{
				if(tmp_all[tmp.name] == undefined) tmp_all[tmp.name] = [];
				tmp_all[tmp.name][i] = tmp.value;
				i++;
			}
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
    try
    {
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
 * @param    {[string] [form_name] 		[标题class或id]}
 * @param    {[string] [action] 		[请求地址]}
 * @param    {[string] [method] 		[请求类型 POST, GET]}
 * @param    {[string] [request-type] 	[回调类型 ajax-url, ajax-fun, ajax-reload]}
 * @param    {[string] [request-value] 	[回调值 ajax-url地址 或 ajax-fun方法]}
 */

function FromInit(form_name)
{
	if(form_name == undefined)
	{
		form_name = 'form.form-validation';
	}
	var editor_tag_name = 'editor-tag';
	var $form = $(form_name);
	var $editor_tag = $form.find('[id='+editor_tag_name+']');
	var editor_count = $editor_tag.length;
	if(editor_count > 0)
	{
		// 编辑器初始化
		var editor = UE.getEditor(editor_tag_name);

		// 编辑器内容变化时同步到 textarea
		editor.addListener('contentChange', function()
		{
			editor.sync();

			// 触发验证
			$editor_tag.trigger('change');
		});
	}
	$form.validator(
	{
		onInValid: function(validity)
		{
			// 错误信息
			var $field = $(validity.field);
			var msg = $field.data('validationMessage') || this.getValidationMessage(validity);
			Prompt(msg);
		},
		submit: function(e)
		{
			if(editor_count > 0)
			{
				// 同步编辑器数据
				editor.sync();

				// 表单验证未成功，而且未成功的第一个元素为 UEEditor 时，focus 编辑器
				if (!this.isFormValid() && $form.find('.' + this.options.inValidClass).eq(0).is($editor_tag))
				{
					// 编辑器获取焦点
					editor.focus();

					// 错误信息
					var msg = $editor_tag.data('validationMessage') || $editor_tag.getValidationMessage(validity);
					Prompt(msg);
				}
			}

			// 通过验证
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
	                processData:false,
					contentType:false,
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
	                			Prompt('['+request_value+']表单定义的方法未定义');
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
		            	Prompt('网络异常错误');
		            }
	            });
			}
			return false;
		}
	});
}
// 默认初始化一次,默认标签[form.form-validation]
FromInit('form.form-validation');

/**
 * [FormDataFill 表单数据填充]
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-14T14:46:47+0800
 * @param    {[json]}    json [json数据对象]
 * @param    {[string]}  tag  [tag标签]
 */
function FormDataFill(json, tag)
{
	if(json != undefined)
	{
		if(tag == undefined)
		{
			tag = 'form.form-validation';
		}
		$form = $(tag);
		for(var i in json)
		{
			$form.find('input[type="hidden"][name="'+i+'"], input[type="text"][name="'+i+'"], input[type="password"][name="'+i+'"], input[type="email"][name="'+i+'"], input[type="number"][name="'+i+'"], input[type="date"][name="'+i+'"], textarea[name="'+i+'"], select[name="'+i+'"], input[type="url"][name="'+i+'"]').val(json[i]);

			// input radio
			$form.find('input[type="radio"][name="'+i+'"]').each(function(temp_value, temp_tag)
			{
				var state = (json[i] == temp_value);
				this.checked = state;
			});
		}

		// 多选插件事件更新
		if($('.chosen-select').length > 0)
		{
			$('.chosen-select').trigger('chosen:updated');
		}
	}
}

/**
 * [Tree 树方法]
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2017-01-13T10:30:23+0800
 * @param    {[int]}    	id    [节点id]
 * @param    {[string]}   	url   [请求url地址]
 * @param    {[int]}      	level [层级]
 */
function Tree(id, url, level)
{
	$.ajax({
		url:url,
		type:'POST',
		dataType:"json",
		timeout:10000,
		data:{"id":id},
		success:function(result)
		{
			if(result.code == 0 && result.data.length > 0)
			{
				html = (id != 0) ? '' : '<table class="am-table am-table-striped am-table-hover">';
				for(var i in result.data)
				{
					// 数据 start
					var is_active = (result.data[i]['is_enable'] == 0) ? 'am-active' : '';
					html += '<tr id="data-list-'+result.data[i]['id']+'" class="tree-pid-'+id+' '+is_active+'"><td>';
					tmp_level = (id != 0) ? parseInt(level)+20 : parseInt(level);
					if(result.data[i]['is_son'] == 'ok')
					{
						html += '<i class="am-icon-plus c-p tree-submit" data-id="'+result.data[i]['id']+'" data-url="'+result.data[i]['ajax_url']+'" data-level="'+tmp_level+'" style="margin-right:8px;width:12px;';
						if(id != 0)
						{
							html += 'margin-left:'+tmp_level+'px;';
						}
						html += '"></i>';
						html += '<span>'+result.data[i]['name']+'</span>';
					} else {
						html += '<span style="padding-left:'+tmp_level+'px;">'+result.data[i]['name']+'</span>';
					}
					// 数据 end

					// 操作项 start
					html += '<div class="fr m-r-20 submit">';
					html += '<span class="am-icon-edit am-icon-sm c-p submit-edit" data-am-modal="{target: \'#data-save-win\'}" data-json=\''+result.data[i]['json']+'\' data-is_exist_son="'+result.data[i]['is_son']+'"></span>';
					if(result.data[i]['is_son'] != 'ok')
					{
						html += '<span class="am-icon-trash-o am-icon-sm c-p m-l-20 m-r-15 submit-delete" data-id="'+result.data[i]['id']+'" data-url="'+result.data[i]['delete_url']+'"></span>';
					}
					html += '</div>';
					// 操作项 end
					
					html += '</td></tr>';
				}
				html += (id != 0) ? '' : '</table>';

				// 防止网络慢的情况下重复添加
				if($('#data-list-'+id).find('.tree-submit').attr('state') != 'ok')
				{
					if(id == 0)
					{
						$('#tree').html(html);
					} else {
						$('#data-list-'+id).after(html);
						$('#data-list-'+id).find('.tree-submit').attr('state', 'ok');
						$('#data-list-'+id).find('.tree-submit').removeClass('am-icon-plus');
						$('#data-list-'+id).find('.tree-submit').addClass('am-icon-minus-square');
					}
				}
			} else {
				$('#tree').find('p').text(result.msg);
				$('#tree').find('img').remove();
			}
		},
		error:function(xhr, type)
		{
			$('#tree').find('p').text('网络异常出错');
			$('#tree').find('img').remove();
		}
	});
}

// 公共数据操作
$(function()
{
	// 多选插件初始化
	if($('.chosen-select').length > 0)
	{
		$('.chosen-select').chosen();
	}
	
	/**
	 * [submit-delete 删除数据列表]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T14:22:39+0800
	 * @param    {[int] 	[data-id] 	[数据id]}
	 * @param    {[string] 	[data-url] 	[请求地址]}
	 */
	$(document).on('click', '.submit-delete', function()
	{
		$('#common-confirm-delete').modal({
			relatedTarget: this,
			onConfirm: function(options)
			{
				// 获取参数
				var $tag = $(this.relatedTarget);
				var id = $tag.data('id');
				var url = $tag.data('url');
				var list_tag = $tag.data('list-tag') || '#data-list-'+id;
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
							$(list_tag).remove();
						} else {
							Prompt(result.msg);
						}
					},
					error:function(xhr, type)
					{
						Prompt('网络异常出错');
					}
				});
			},
			onCancel: function(){}
		});
	});

	/**
	 * [submit-state 公共数据状态操作]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T14:22:39+0800
	 * @param    {[int] 	[data-id] 	[数据id]}
	 * @param    {[int] 	[data-state][状态值]}
	 * @param    {[string] 	[data-url] 	[请求地址]}
	 */
	$(document).on('click', '.submit-state', function()
	{		
		// 获取参数
		var $tag = $(this);
		var id = $tag.data('id');
		var state = ($tag.data('state') == 1) ? 0 : 1;
		var url = $tag.data('url');
		if(id == undefined || url == undefined)
		{
			Prompt('参数配置有误');
			return false;
		}

		// 请求更新数据
		$.ajax({
			url:url,
			type:'POST',
			dataType:"json",
			timeout:10000,
			data:{"id":id, "state":state},
			success:function(result)
			{
				if(result.code == 0)
				{
					Prompt(result.msg, 'success');

					// 成功则更新数据样式
					if($tag.hasClass('am-success'))
					{
						$tag.removeClass('am-success');
						$tag.addClass('am-default');
						if($('#data-list-'+id).length > 0)
						{
							$('#data-list-'+id).addClass('am-active');
						}
					} else {
						$tag.removeClass('am-default');
						$tag.addClass('am-success');
						if($('#data-list-'+id).length > 0)
						{
							$('#data-list-'+id).removeClass('am-active');
						}
					}
					$tag.data('state', state);
				} else {
					Prompt(result.msg);
				}
			},
			error:function(xhr, type)
			{
				Prompt('网络异常出错');
			}
		});
	});

	/**
	 * [submit-edit 公共编辑]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T13:53:13+0800
	 */
	$(document).on('click', '.submit-edit', function()
	{
		// 窗口标签
		var tag = $(this).data('tag') || 'data-save-win';

		// 更改窗口名称
		if($('#'+tag).length > 0)
		{
			$title = $('#'+tag).find('.am-popup-title');
			$title.text($title.data('edit-title'));
		}
		
		// 填充数据
		FormDataFill($(this).data('json'), '#'+tag);
	});

	/**
	 * [tree-submit 公共无限节点]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-25T22:12:10+0800
	 */
	$('#tree').on('click', '.tree-submit', function()
	{
		var id = parseInt($(this).data('id')) || 0;
		// 状态
		if($('#data-list-'+id).find('.tree-submit').attr('state') == 'ok')
		{
			if($(this).hasClass('am-icon-plus'))
			{
				$(this).removeClass('am-icon-plus');
				$(this).addClass('am-icon-minus-square');
			} else {
				$(this).removeClass('am-icon-minus-square');
				$(this).addClass('am-icon-plus');
			}
			$('.tree-pid-'+id).toggle(100);
		} else {
			var url = $(this).data('url') || '';
			var level = parseInt($(this).data('level')) || 0;
			if(id > 0 && url != '')
			{
				Tree(id, url, level);
			} else {
				Prompt('参数有误');
			}
		}
	});

	/**
	 * [tree-submit-add 公共无限节点新增按钮处理]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-25T22:11:34+0800
	 */
	$('.tree-submit-add').on('click', function()
	{
		// 更改窗口名称
		$title = $('#data-save-win').find('.am-popup-title');
		$title.text($title.data('add-title'));

		// 清空表单
		FormDataFill({"id":"", "pid":0, "name":"", "sort":0, "is_enable":1});

		// 移除菜单禁止状态
		$('form select[name="pid"]').removeAttr('disabled');

		// 校验成功状态增加失去焦点
		$('form').find('.am-field-valid').each(function()
		{
			$(this).blur();
		});
	});

});