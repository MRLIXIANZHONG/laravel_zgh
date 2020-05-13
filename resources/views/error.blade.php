<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>404 Page</title>
  <link rel="stylesheet" href="/css/style.css">

</head>
<body>

<div class="about">
   <a class="bg_links social portfolio" href="#">
      <span class="icon"></span>
   </a>
   <a class="bg_links social dribbble" href="#">
      <span class="icon"></span>
   </a>
   <a class="bg_links social linkedin" href="#">
      <span class="icon"></span>
   </a>
   <a class="bg_links logo"></a>
</div>



    <section class="wrapper">

        <div class="container">

            <div id="scene" class="scene" data-hover-only="false">


                <div class="circle" data-depth="1.2"></div>

                <div class="one" data-depth="0.9">
                    <div class="content">
                        <span class="piece"></span>
                        <span class="piece"></span>
                        <span class="piece"></span>
                    </div>
                </div>

                <div class="two" data-depth="0.60">
                    <div class="content">
                        <span class="piece"></span>
                        <span class="piece"></span>
                        <span class="piece"></span>
                    </div>
                </div>

                <div class="three" data-depth="0.40">
                    <div class="content">
                        <span class="piece"></span>
                        <span class="piece"></span>
                        <span class="piece"></span>
                    </div>
                </div>

                <p class="p404" data-depth="0.50">404</p>
                <p class="p404" data-depth="0.10">404</p>

            </div>

            <div class="text">
                @if(isset($msg))
                    <article>
                        <p style="font-size: 50px;width: 800px">{{$msg}}</p>
                        {{--<button>返回首页</button>--}}
                    </article>
                @else
                    <article>
                        <p style="font-size: 50px;width: 800px">找不到地址。请输入正确的地址</p>
                        {{--<button>返回首页</button>--}}
                    </article>
                @endif
            </div>

        </div>
    </section>
	
	<script src='js/parallax.min.js'></script>
	<script src="js/script.js"></script>

</body>
</html>