$(function () {
  $('.js-popover').popover()
  $('.js-tooltip').tooltip()
  $('#tall-toggle').click(function () {
    $('#tall').toggle()
  })
  $('#ff-bug-input').one('focus', function () {
    $('#myModal2').on('focus', function () {
      reportFirefoxTestResult(false)
    })
    $('#ff-bug-input').on('focus', function () {
      reportFirefoxTestResult(true)
    })
  })
})
$('#main').css('height', $(window).height());