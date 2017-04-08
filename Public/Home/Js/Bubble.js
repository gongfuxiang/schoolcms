$(function()
{
	// 同步个人签名操作
	$('.sign-submit').on('click', function()
	{
		if($(this).hasClass('am-primary'))
		{
			$(this).removeClass('am-primary');
		} else {
			$(this).addClass('am-primary');
		}
	});

	// 查看更多
	$('.submit-more').on('click', function()
	{
		// 参数
		var url = $(this).data('url');
		var page = parseInt($(this).attr('data-page'));
		var $this = $(this);

		// 禁用按钮
		$this.addClass('am-disabled');

		// ajax请求
		$.ajax({
			url:url,
			type:'POST',
			dataType:"json",
			timeout:10000,
			data:{"page":page},
			success:function(result)
			{
				if(result.code == 0)
				{
					var html = '';
					for(var i in result.data)
					{
						html += '<div class="am-panel am-panel-default am-radius list-content" id="data-list-'+result.data[i]['id']+'">';
						html += '<div class="am-panel-bd">';
						html += '<div class="list-title o-h">';
						html += '<img src="'+__public__+'/Home/Images/user-img-sm.gif" class="am-circle am-fl" width="48" height="48" />';
						html += '<div class="am-fl m-l-10 m-t-5">';
						html += '<span class="block">'+result.data[i]['nickname']+'</span>';
						html += '<span class="block cr-999">'+result.data[i]['add_time']+'</span>';
						html += '</div>';
						if(result.data[i]['user_id'] == __user_id__)
						{
							html += '<div class="am-fr">';
							html += '<i class="am-icon-trash-o c-p submit-delete" data-am-popover="{content: \''+$this.data('del-text')+'\', trigger: \'hover focus\'}" data-id="{{$v.id}}" data-url="'+$this.data('del-url')+'"></i>';
							html += '</div>';
						}
						html += '</div>';
						html += '<div class="m-t-10">'+result.data[i]['content']+'</div>';
						html += '</div>';
						html += '</div>';
						$('#mood-list').append(html);
						$this.attr('data-page', page+1);
					}
				} else {
					Prompt(result.msg);
				}
				$this.removeClass('am-disabled');
			},
			error:function(xhr, type)
			{
				$this.removeClass('am-disabled');
				Prompt('网络异常错误');
			}
		});
	});
});