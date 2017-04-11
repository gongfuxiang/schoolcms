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

	// 说说点赞
	$(document).on('click', '.praise-submit', function()
	{
		// 参数
		var id = $(this).attr('data-id');
		var uid = $(this).attr('data-uid');
		var url = $(this).data('url');
		var num = parseInt($(this).prev().text());
		var $this = $(this);

		// 不能点赞自己的说说
		if(uid == __user_id__)
		{
			Prompt($('#bubble-comments').data('mood-praise-msg'));
			return false;
		}

		// ajax请求
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
					if($this.hasClass('cr-999'))
					{
						$this.prev().text(num+1);
						$this.removeClass('cr-999');
						$this.addClass('cr-blue');
					} else {
						$this.prev().text(num-1);
						$this.removeClass('cr-blue');
						$this.addClass('cr-999');
					}
				} else {
					Prompt(result.msg);
				}
			},
			error:function(xhr, type)
			{
				Prompt('网络异常错误');
			}
		});
	});

	// 说说评论
	$(document).on('click', '.comments-submit, .reply-submit', function()
	{
		// 不能点赞自己的说说
		if($(this).attr('data-uid') == __user_id__)
		{
			Prompt($('#bubble-comments').data('mood-comments-msg'));
			return false;
		}

		// 参数
		var $modal = $('#bubble-comments');
		$modal.attr('data-id', $(this).data('id'));
		$modal.attr('data-reply-id', $(this).data('reply-id') || 0);
		$modal.attr('data-parent-id', $(this).data('parent-id') || 0);

		// @用户
		var nickname = $(this).data('nickname');
		if(nickname != undefined)
		{
			$modal.find('.am-modal-hd').text('@'+nickname);
		} else {
			$modal.find('.am-modal-hd').text('');
		}
		
		$modal.modal(
		{
			relatedTarget: this,
			onConfirm: function(e)
			{
				// 内容是否能为空
				if($modal.find('textarea').val().length == 0)
				{
					Prompt($modal.find('textarea').data('validation-message'));
					return false;
				}
				
				// ajax请求
				$.ajax({
					url:$modal.data('url'),
					type:'POST',
					dataType:"json",
					timeout:10000,
					data:{"mood_id":$modal.attr('data-id'), "reply_id":$modal.attr('data-reply-id'), "parent_id":$modal.attr('data-parent-id'), "content":e.data},
					success:function(result)
					{
						if(result.code == 0)
						{
							$modal.find('textarea').val('');
							Prompt(result.msg, 'success');
							setTimeout(function()
							{
								window.location.reload();
							}, 1000);
						} else {
							Prompt(result.msg);
						}
					},
					error:function(xhr, type)
					{
						Prompt('网络异常错误');
					}
				});
			},
			onCancel: function(e){}
		});
	});
});