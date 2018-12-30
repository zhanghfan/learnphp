<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wx883f62bbf6539e43", "7a515263313ed04833d6a416e679a30b");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>张帆的天气预报</title>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css">
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>
<style>
.ui-bar-f
{
color:red;  
background-color:red;
}
.ui-body-f
{
color:white;
}
</style>

    
<body>
<meta charset="UTF-8">
<div data-role="page" id="pageone" data-theme="a"  
style="background:url(images/biz_plugin_weather_shenzhen_bg.jpg) 50% 0 no-repeat;background-size:cover">>
  <div data-role="content">
   <div class="ui-grid-a">
     <div class="ui-block-a" align="center">
       <p style="font-size:70px"><span id="city"></span></p>
       <p style="font-size:40px"><span id="district"></span> <span id="street"></span></p>
       <p style="font-size:50px">今天 <span id="update_time"></span> 发布</p>
       <p style="font-size:50px">湿度: <span id="shidu"></span></p>
     </div>
     <div class="ui-block-b" align="center">
       <br>
       <br>
       <a href="#"><img src="images/biz_plugin_weather_0_50.png"></a>
       <p style="font-size:50px">PM2.5: <span id="pm25"></span></p>
       <p style="font-size:50px">空气质量: <span id="quality"></span></p>
     </div>
   </div>
  </div>
  <div data-role="content">
   <div class="ui-grid-a">
     <div class="ui-block-a" align="right">
       <a href="#"><img src="images/biz_plugin_weather_qing.png"></a>
     </div>
     <div class="ui-block-b" align="left">
       <p style="font-size:50px"><span id="week"></span></p>
       <p style="font-size:50px"><span id="high1"></span>~<span id="low1"></span></p>
       <p style="font-size:45px"><span id="fx"></span> <span id="type"></span></p>
     </div>
   </div>
  </div>
  <div data-role="content">
    <div class="ui-grid-b">
     <div class="ui-block-a" align="center">
       <a href="#"><img src="images/biz_plugin_weather_qing.png"></a>
	   <p style="font-size:45px"><span id="week_next1"></span></p>
       <p style="font-size:45px"><span id="high1_next1"></span>~<span id="low1_next1"></span></p>
       <p style="font-size:40px"><span id="fx_next1"></span> <span id="type_next1"></span></p>
     </div>
     <div class="ui-block-b" align="center">
       <a href="#"><img src="images/biz_plugin_weather_qing.png"></a>
       <p style="font-size:45px"><span id="week_next2"></span></p>
       <p style="font-size:45px"><span id="high1_next2"></span>~<span id="low1_next2"></span></p>
       <p style="font-size:40px"><span id="fx_next2"></span> <span id="type_next2"></span></p>
     </div>
     <div class="ui-block-c" align="center">
       <a href="#"><img src="images/biz_plugin_weather_qing.png"></a>
       <p style="font-size:45px"><span id="week_next3"></span></p>
       <p style="font-size:45px"><span id="high1_next3"></span>~<span id="low1_next3"></span></p>
       <p style="font-size:40px"><span id="fx_next3"></span> <span id="type_next3"></span></p>
     </div>
    </div>
  </div>
</div> 

</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: true,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
    'scanQRCode',
    'getLocation',
      // 所有要调用的 API 都要加到这个列表中
    ]
  });
  wx.ready(function () {
    wx.scanQRCode({
needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
success: function (res) {
var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
}
});
    // 在这里调用 API
    wx.getLocation({
            type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
            success: function (res) {
                latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                var speed = res.speed; // 速度，以米/每秒计
                var accuracy = res.accuracy; // 位置精度
                $.ajax({
 					 type: 'post',
                     url: 'http://www.yitsu.cn/wx/Ajax/read',
                     data: {latitude: latitude, longitude: longitude},
                     dataType: 'json',
                     success: function (data) {
                       if (data.status == 0) {
                       	 alert(data.msg);
                       } else {
                         $("#city").text(data.city);
                         $("#district").text(data.district);
                         $("#street").text(data.street);
                         $("#update_time").text(data.update_time);
                         $("#shidu").text(data.shidu);
                         $("#pm25").text(data.pm25);
                         $("#quality").text(data.quality);
                         $("#week").text(data.week);
                         $("#high1").text(data.high1);
                         $("#low1").text(data.low1);
                         $("#fx").text(data.fx);
                         $("#type").text(data.type);
                         $("#week_next1").text(data.week_next1);
                         $("#high1_next1").text(data.high1_next1);
                         $("#low1_next1").text(data.low1_next1);
                         $("#fx_next1").text(data.fx_next1);
                         $("#type_next1").text(data.type_next1);
                         $("#week_next2").text(data.week_next2);
                         $("#high1_next2").text(data.high1_next2);
                         $("#low1_next2").text(data.low1_next2);
                         $("#fx_next2").text(data.fx_next2);
                         $("#type_next2").text(data.type_next2);
                         $("#week_next3").text(data.week_next3);
                         $("#high1_next3").text(data.high1_next3);
                         $("#low1_next3").text(data.low1_next3);
                         $("#fx_next3").text(data.fx_next3);
                         $("#type_next3").text(data.type_next3);
                       }
                      },
                      error: function () {
                       	alert("程序异常");
                      }
                });
            }
        });

  });
</script>
</html>
