<!DOCTYPE html> <html lang=cn class><!--
 Page saved with SingleFile 
 url: https://developers.weixin.qq.com/miniprogram/dev/devtools/devtools.html 
 saved date: Sat Dec 21 2019 23:50:11 GMT+0800 (中国标准时间)
--><meta charset=utf-8>
<meta name=viewport content="width=device-width,initial-scale=1">
<title>概览 | 微信开放文档</title>
<meta name=msapplication-TileColor content=#ffffff>
<meta name=theme-color content=#ffffff>
<style>@media (max-width:1080px){body{background-color:#f7f7f7}}@media (max-width:$MQMobile){.sidebar-button{display:block}}@keyframes weuiLoading{0%{transform:rotate(0deg)}to{transform:rotate(1turn)}}html{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{line-height:1.6;font-family:-apple-system,BlinkMacSystemFont,SF UI Text,Helvetica Neue,PingFang SC,Hiragino Sans GB,Microsoft YaHei UI,Microsoft YaHei,Arial,sans-serif;color:#222;font-size:14px;-webkit-font-smoothing:antialiased}*{margin:0;padding:0;-webkit-overflow-scrolling:touch;-webkit-tap-highlight-color:transparent}ul{list-style-type:none}a,a:hover{text-decoration:none}@media (-webkit-max-device-pixel-ratio:1){::-webkit-scrollbar-track-piece{background-color:#fff}::-webkit-scrollbar{width:6px;height:6px}::-webkit-scrollbar-thumb{background-color:#c2c2c2;background-clip:padding-box;min-height:28px}::-webkit-scrollbar-thumb:hover{background-color:#a0a0a0}}html{height:100%}.main-contontaier__bd{position:relative}.page-inner{position:relative;padding:0 436px;padding-top:40px;padding-bottom:100px}.page-inner{margin:0 auto;max-width:1832px;min-width:1592px;box-sizing:border-box}@media (max-width:1592px){.page-inner{padding-left:0;padding-right:0;width:800px;min-width:0}}@media (max-width:1252px){.page-inner{padding-left:0;padding-right:0;width:800px;min-width:0}}@media (max-width:1080px){.main-container{margin-top:112px!important}.page-inner{padding:24px 16px!important;margin:0!important;width:auto;min-width:0;max-width:none}.main-contontaier__bd{background-color:#fff}}.content{max-width:100%;font-size:14px;line-height:1.6;overflow:hidden;word-break:break-word}.content h3{margin-top:2em;margin-bottom:.5em}.content h1:first-child,.content h2:first-child,.content h3:first-child,.content h4:first-child,.content h5:first-child,.content h6:first-child{margin-top:0}.content a{color:#576b95}.content h3{font-size:16px;font-weight:600}.content p{margin-bottom:.5em}.content ul{padding-left:2em;margin:.8em 0}.content ul li{list-style:disc}.content img{max-width:100%;margin:1em 0}.content a.header-anchor{font-size:0;display:block;height:120px;margin-top:-120px;visibility:hidden}.content h1:hover .header-anchor,.content h2:hover .header-anchor,.content h3:hover .header-anchor,.content h4:hover .header-anchor,.content h5:hover .header-anchor,.content h6:hover .header-anchor{opacity:1}@keyframes nprogress-spinner{0%{transform:rotate(0deg)}to{transform:rotate(1turn)}}@keyframes weuiDesktopBtnLoading{0%{transform:rotate(0deg)}to{transform:rotate(1turn)}}</style>
<meta name=description content=微信开发者平台文档><link rel="shortcut icon" type=image/x-icon href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAADAklEQVRYhe2WQWgUZxiGn/ffuFlrLkoIMbOsWQxWikcvPRVFqKaKyQhejKcipfRUPPQUiAcpHrx5kSL1IK0HXQ2SKqXUSo/VHkREZFNjM7OVZSkeQtls43wesqmandmMzUYP7Xub/3/ne56BYf6B/3qUtpi/lh+yhu1GtgtsyKAX1Le4a1VBDVTGdFNZ/RgcCMqrFhj6bihbn/9rLDI7jvFeWtnm5PtOOp3rfudCebjceG0B74o3Zhadxuh7LXAroSq54+FoeCGVwLZrA71zf/MVZiOrAreQdLVnHcceHqjUEgUGpwb7G/XGTbDtHYW/wD3I5rK7Zj6aedIiUJws9s0vzN9aO/gLie6u7g8eHXxUBXBLy41n81+3g0t6CkQpCFGzmxDbvshajIOlF86GY8Go4ZTZF/qVjcJtkXS3jeRd4baEfmWjU2afUOzbb2bD3hVvDMBN2IQjslOJvuJS4Ac3AMJDYWDGeGLXGA8PhQFA4Ac3TFxK6mL25YRNOHdu8uwewwaSi69eZtp8OVr2LLbW5Fv+3OTZPS6KOJJcA8Fhr+TtByhOFQsRnEzqRnCyOFUsAHglb7/gcLvZUaQj8kqbfzFjZ7ti02QO6Gn3VEvGwBxGz4ojxe0ug8KKcCDNwGYPSNc1KLjUg9ck6nHAzFvDQ+AkpTo21yJmzDikW29LQNJ1h3FeqP7m6SzkyH3jQj/8E7j45vlcnPanqw4gp/VfAE9WuKeDdNXW5zZ8Ds3DaNqfrnZJR9P/Ia4GDk7uk/JwufaPAMDvfuUHTJ+R7sj993DTsWA0KL209GrylzePGPrWsFxn2arj9Gk4Gp5f5tSafCm/N7Jn1zvIv71O2aOP/ccPlm+4uHbkonsdwYr7zunjbZvefT8ODtAVe1+k3fbSsSdUQfxq2A6MwbZM6SHYT85xeXbkj+8BAiqJ/VgBwz5sDnsKOtFf6D9zZ+edBYCtpa19ddV3mKxXpk1ERJJqjqhqmcxvswdnk2lxwnGLA6WBn2Xc25BlfPl//P/pdJ4DItcX43LWrMQAAAAASUVORK5CYII=">
</head>
 <body>
 <div id=app><div class=theme-container><div class=theme-container> <div class=main-container style=margin-top:0px><div class=main-contontaier__bd style=min-height:888px> <div class=page__wrp><main class=page><div class=page-inner style=min-height:888px> <div id=docContent><div class="content custom">
   <h3 id=概览><a href=#%E6%A6%82%E8%A7%88 aria-hidden=true class=header-anchor>#</a> 1 添加会员/等级划分</h3>
   <p>1 等级划分规则</p>
   <div align="center">
     <table width="521" border="1">
       <tr>
         <td width="81"><div align="center">会员等级</div></td>
         <td width="80"><div align="center">发布商品</div></td>
         <td width="83"><div align="center">设置域名</div></td>
         <td width="68"><div align="center">添加会员</div></td>
         <td width="82"><div align="center">专属客服</div></td>
         <td width="87"><div align="center">设置收款</div></td>
         </tr>
       <tr>
         <td><div align="center">管理员</div></td>
         <td><div align="center">支持</div></td>
         <td><div align="center">支持</div></td>
         <td><div align="center">支持</div></td>
         <td><div align="center">支持</div></td>
         <td><div align="center">支持</div></td>
         </tr>
       <tr>
         <td><div align="center">会员</div></td>
         <td><div align="center">不支持</div></td>
         <td><div align="center">支持</div></td>
         <td><div align="center">不支持</div></td>
         <td><div align="center">不支持</div></td>
         <td><div align="center">不支持</div></td>
         </tr>
     </table>
   </div>
   <p>&nbsp;</p>
   <p>1添加用户：在左边找到用户模块，找到“<strong>用户管理</strong>”里面点击 <strong>＋</strong>号添加，子会员 （您所添加的会员就是您的下家账户，您可以查看他的商品<br>
     删修或者修改都是可以的，并且它不能设置收款方式，但是你可以设置！
     ）</p>
   <p>2 输入下家用户名，选择角色为会员，输入手机号（可选），选择性别，输入密码，点击提交即可 </p>
   <p><img src="../../static/admin/images/tjhy.png" alt=devtools width="879" height="572"><br>
   </p>
   </div>
 </div> </div></main></div></div></div> </div></div></div>
 
 
