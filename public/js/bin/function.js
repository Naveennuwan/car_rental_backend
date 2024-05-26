$(document).ready(function(){
  $('a[href^="#"]').on("click", function(){
    var speed = 400;
    var href = $(this).attr("href");
    var target = $(href == "#" || href == "" ? "html" : href);
    var offset = target.offset().top;
    $("body,html").animate({
        scrollTop:offset
      }, speed, "swing");
    return false;
  });
});


// アニメーションの実行等
$(function(){
  $('body').addClass('do');
});
$(window).on('load',function(){
  $('body').removeClass('do');
  $('body').addClass('done');
});


//スクロール検知
$(function(){
  var timeoutId;
  window.addEventListener("scroll",function(){
    $("body").addClass("scrollActive");
    clearTimeout(timeoutId);
    timeoutId = setTimeout(function(){
      $("body").removeClass("scrollActive");
    },100);
  });
});
$(window).scroll(function (){
  var scroll = $(window).scrollTop();
  if (scroll){
    $("body").removeClass("scrollTop");
  } else {
    $("body").addClass("scrollTop");
  }
});

// TELリンク無効
var ua = navigator.userAgent.toLowerCase();
var isMobile = /iphone/.test(ua)||/android(.+)?mobile/.test(ua);
if (!isMobile) {
  $('a[href^="tel:"]').on('click', function(e) {
    e.preventDefault();
  });
}


// ハンバーガーメニュー
$(".openbtn").click(function () {
  $(this).toggleClass('active');
    $("#g-nav").toggleClass('panelactive');
});
$("#g-nav a").click(function () {
    $(".openbtn").removeClass('active');
    $("#g-nav").removeClass('panelactive');
});


// 検索窓
$(".open-btn").click(function () {
  $(this).toggleClass('btnactive');
  $("#search-wrap").toggleClass('panelactive');
  $('#search-text').focus();
});


// アコーディオン
$(function () {
  $(".js-accordion-title").on("click", function() {
    $(this).next().slideToggle(200);
    $(this).toggleClass("open",200);
  });
});


// パスワード表示・非表示
function pushHideButton() {
  var txtPass = document.getElementById("password");
  var btnEye = document.getElementById("buttonEye");
  if (txtPass.type === "text") {
    txtPass.type = "password";
    btnEye.className = "fa fa-eye";
  } else {
    txtPass.type = "text";
    btnEye.className = "fa fa-eye-slash";
  }
}


