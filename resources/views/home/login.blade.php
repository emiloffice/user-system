<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>Multiverse Entertainment LLC | user log in</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="Welcome to Multiverse Entertainment LLC, a professional virtual reality game development and publishing company.">
    <meta name="DC.title" content="Home">
    <meta name="robots" content="index,follow">
    <meta name="author" content="EmilWong">
    <link rel="shortcut icon" type="image/x-icon" href="//{{getenv('RESOURCE_PATH')}}/favicon.ico" media="screen" />
    <link href="//{{getenv('RESOURCE_PATH')}}/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet">
    <link href="//{{getenv('RESOURCE_PATH')}}/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="//{{getenv('RESOURCE_PATH')}}{{ mix('/css/app.css') }}" rel="stylesheet">
    <link href="//{{getenv('RESOURCE_PATH')}}{{ mix('/css/login.css') }}" rel="stylesheet">
</head>
<body>
    <div class="login-header">
        <div class="container">
            <div class="logo"><a href="{{url('ambassador')}}"><img src="//{{getenv('RESOURCE_PATH')}}/img/logo.png" alt="logo"></a></div>
        </div>
    </div>
    <div class="login-content">
        <div class="container">
            <form action="{{ url('login', '', $HTTPS_REQUEST) }}" class="panel" method="POST">
                {{--{!! csrf_field() !!}--}}
                {{ csrf_field() }}
                <div class="login-input-group">
                    <label for="email"><i class="required">*</i>Email</label>
                    @if($errors->has('email'))
                        @foreach($errors->get('email') as $message)
                            <input type="email" id="email" name="email" class="error-input" onclick="tips('{{$message}}', 'email')" value="{{ old('email') }}">
                        @endforeach
                    @elseif(isset($res))
                        <input type="email" id="email" name="email" onclick="tips('{{$res}}','email')" class="error-input" >
                        @else
                        <input type="email" id="email" name="email" value="{{ old('email') }}">
                    @endif
                </div>
                <div class="login-input-group">
                    <label for="password"><i class="required">*</i>Password</label>
                    @if($errors->has('password'))
                        @foreach($errors->get('password') as $message)
                            <input type="password" id="password" name="password" onclick="tips('{{$message}}','password')" class="error-input" >
                            @endforeach
                    @elseif(isset($res))
                        <input type="password" id="password" name="password" onclick="tips('{{$res}}','password')" class="error-input" >
                        @else
                        <input type="password" id="password" name="password">
                    @endif
                </div>

                <div class="login-input-group">
                    <button class="login-btn-default btn-submit">Log In</button>
                    <a class="reg-btn-oauth" href="{{url('OAuth/fb-login', '',  $HTTPS_REQUEST)}}"><p><i class="fa fa-facebook"></i> Log In</p></a>
                    <a class="reg-btn-oauth" href="{{url('OAuth/twitter-login', '',  $HTTPS_REQUEST)}}"><p><i class="fa fa-twitter"></i> Log In</p></a>
                </div>
                <div class="login-input-group">
                    <p>if you don't have an account, <a href="{{ url('register', '',  $HTTPS_REQUEST) }}" class="login-href">sign up</a> today!</p>
                </div>
            </form>
        </div>
    </div>
    <div class="login-footer">
        <div class="container">
            <div class="left">
                <a href="#">Terms of Service</a>|<a href="#">Privacy Policy</a>
                <p>Copyright © Multiverse Entertainment LLC</p>
            </div>
            <div class="right"></div>
        </div>
    </div>
</body>
<script src="//{{getenv('RESOURCE_PATH')}}/js/jquery-3.2.1.js"></script>
<script src="//{{getenv('RESOURCE_PATH')}}/bootstrap/3.3.7/js/bootstrap.js"></script>
<script>
    function tips(content,copybtnid){
        var cpb = document.getElementById(copybtnid);
        $(cpb).tooltip({title: content, placement: "right", trigger: "manual"});
        $(cpb).tooltip('show');
        cpb.onfocus=function(){$(cpb).removeClass('error-input')};
        cpb.onmouseout=function(){$(cpb).tooltip('destroy')};
    }
</script>
</html>
