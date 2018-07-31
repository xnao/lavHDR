<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台登录-X-admin2.0 @yield('title')</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    @section('style')
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/css/font.css">
        <link rel="stylesheet" href="/css/xadmin.css">
        <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
        <script src="/lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="/js/xadmin.js"></script>
        <script type="text/javascript" src="/js/myjs.js"></script>
    @show
</head>
<body>

<!-- 中部开始 -->

<!-- 右侧主体开始 -->
<div class="layui-tab-content">
    <div class="layui-tab-item layui-show">
        @section('content')
            <iframe src='/welcome.html' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
        @show
    </div>
</div>

<!-- 右侧主体结束 -->

<!-- 中部结束 -->

</body>
</html>