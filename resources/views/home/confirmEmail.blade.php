<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>Multiverse Entertainment LLC</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="Welcome to Multiverse Entertainment LLC, a professional virtual reality game development and publishing company.">
    <meta name="DC.title" content="Home">
    <meta name="robots" content="index,follow">
    <meta name="author" content="EmilWong">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="//{{getenv('RESOURCE_PATH')}}/favicon.ico" media="screen" />
    <link href="//{{getenv('RESOURCE_PATH')}}/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet">
    <link href="//{{getenv('RESOURCE_PATH')}}{{ mix('/css/app.css') }}" rel="stylesheet">
    <link href="//{{getenv('RESOURCE_PATH')}}{{ mix('/css/login.css') }}" rel="stylesheet">
</head>
<body>
<div class="login-header">
    <div class="container">
        <div class="logo"><img src="//{{getenv('RESOURCE_PATH')}}/img/logo.png" alt="logo"></div>
    </div>
</div>
<div class="login-content">
    <div class="container">
        <form action="{{ url('verify-email-default', '',$HTTPS_REQUEST) }}" class="panel" method="POST">
            {{--{!! csrf_field() !!}--}}
            {{ csrf_field() }}
            <div class="login-input-group">
                <label for="email">Email</label>
                @if($errors->has('email'))
                    @foreach($errors->get('email') as $message)
                        <input type="email" id="email" name="email" class="default-input-min error-input" onclick="tips('{{$message}}', 'email')" value="{{ $email }}" readonly>
                    @endforeach
                @else
                    <input type="email" id="email" name="email" class="default-input-min" value="{{ $email }}" readonly>
                @endif
                    <span onclick="sendCode()" class="btn-send">send</span>
            </div>
            <div class="login-input-group">
                <label for="code">Verification code</label>
                @if($errors->has('code'))
                    @foreach($errors->get('code') as $message)
                        <input type="text" id="code" name="code" class="error-input" onclick="tips('{{$message}}','code')" >
                    @endforeach
                    @elseif(isset($codeError))
                    <input type="text" id="code" name="code" class="error-input" onclick="tips('{{$codeError}}','code')" >
                    @else
                    <input type="text" id="code" name="code">
                @endif
            </div>

            <div class="login-input-group">
                <button class="login-btn-default btn-submit">Confirm</button>
                {{--<button class="login-btn-default btn-facebook">Logoin&Like</button>--}}
                {{--<button class="btn-twitter login-btn-default">Login&Follow</button>--}}
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
<script src="//{{getenv('RESOURCE_PATH')}}/layer/v3.0.3/layer.js"></script>
<script>

    function sendCode(){
        var email = $('#email').val();
        if(email !== '') {
            $.ajax({
                url:'/send-email',
                type: 'POST',
                dataType: 'JSON',
                data: {email:email,_token:'{{ csrf_token() }}'},
                success: function (res) {
                    layer.msg('Sending, check your inbox', {
                        icon: 16
                        ,shade: 0.01
                    });
                },
                error: function () {
                    layer.msg('error, please try again later', {
                        icon: 5
                        ,shade: 0.01
                    });
                }
            });
        }else {

        }
    }
    function tips(content,copybtnid){
        var cpb = document.getElementById(copybtnid);
        $(cpb).tooltip({title: content, placement: "right", trigger: "manual"});
        $(cpb).tooltip('show');
        cpb.onfocus=function(){$(cpb).removeClass('error-input')};
        cpb.onmouseout=function(){$(cpb).tooltip('destroy')};
    }
</script>
</html>
