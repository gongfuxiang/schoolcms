$(function()
{
  // 全屏操作
  $('#admin-fullscreen').on('click', function() {
    $.AMUI.fullscreen.toggle();
  });
  $(document).on($.AMUI.fullscreen.raw.fullscreenchange, function() {
    $('.admin-fulltext').text($.AMUI.fullscreen.isFullscreen ? '退出全屏' : '开启全屏');
  });
});