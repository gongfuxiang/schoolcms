$(function()
{
    // 颜色选择器
    var $input_tag = $('input[name="title"]');
    var $title_color = $('input[name="title_color"]');
    $(".colorpicker-submit").colorpicker(
    {
        fillcolor:true,
        success:function(o, color)
        {
            $input_tag.css('color', color);
            $title_color.val(color);
        },
        reset:function(o)
        {
            $input_tag.css('color', '');
            $title_color.val('');
        }
    });

    /* 搜索切换 */
    var $more_where = $('.more-where');
    $more_submit = $('.more-submit');
    $more_submit.find('input[name="is_more"]').change(function()
    {
        if($more_submit.find('i').hasClass('am-icon-angle-down'))
        {
            $more_submit.find('i').removeClass('am-icon-angle-down');
            $more_submit.find('i').addClass('am-icon-angle-up');
        } else {
            $more_submit.find('i').addClass('am-icon-angle-down');
            $more_submit.find('i').removeClass('am-icon-angle-up');
        }
    
        if($more_submit.find('input[name="is_more"]:checked').val() == undefined)
        {
            $more_where.addClass('none');
        } else {
            $more_where.removeClass('none');
        }
    });

    // 日期选择
    var $time_start = $('#time_start');
    var $time_end = $('#time_end');
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

    var checkin = $time_start.datepicker({}).on('changeDate.datepicker.amui', function(ev) {
        var newDate = new Date(ev.date)
        newDate = (ev.date.valueOf() > checkout.date.valueOf() || ev.date.valueOf() == checkout.date.valueOf()) ? newDate.setDate(newDate.getDate() + 1) : checkout.date.valueOf();
        checkout.setValue(newDate);
        
        checkin.close();
        $time_end[0].blur();
    }).data('amui.datepicker');
    var checkout = $time_end.datepicker({
        onRender:function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'am-disabled' : '';
        }
    }).on('changeDate.datepicker.amui', function(ev) {
      checkout.close();
    }).data('amui.datepicker');
});