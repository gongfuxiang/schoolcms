$(function()
{
	// 邮箱编辑器初始化
	if($('.table-nav .am-active').data('type') == 'message')
	{
		// 配置信息
		var toolbars = [[
	            'fullscreen', 'source', '|', 'undo', 'redo', '|',
	            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
	            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
	            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
	            'directionalityltr', 'directionalityrtl', 'indent', '|',
	            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|', 'link', 'unlink', 'anchor', '|',
	            'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
	            'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
	            'print', 'preview', 'searchreplace', 'drafts', 'help'
	        ]];
	    var config = {
				toolbars: toolbars,
				initialFrameHeight : 150
			}
		var ue = UE.getEditor('email_user_reg', config);
		var ue = UE.getEditor('email_user_forget_pwd', config);
	}
});