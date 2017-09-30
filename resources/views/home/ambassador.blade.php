<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>Multiverse Entertainment LLC | Ambassador Project</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">--}}
    <meta name="description" content="Welcome to Multiverse Entertainment LLC, a professional virtual reality game development and publishing company.">
    <meta name="DC.title" content="Home">
    <meta name="robots" content="index,follow">
    <meta name="author" content="EmilWong">
    <link rel="shortcut icon" type="image/x-icon" href="//{{getenv('RESOURCE_PATH')}}/favicon.ico" media="screen" />
    <link href="//{{getenv('RESOURCE_PATH')}}/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet">
    <link href="//{{getenv('RESOURCE_PATH')}}{{ mix('/css/app.css') }}" rel="stylesheet">
    <link href="//{{getenv('RESOURCE_PATH')}}{{ mix('/css/footer.css') }}" rel="stylesheet">
    <link href="//{{getenv('RESOURCE_PATH')}}{{ mix('/css/ambassador.css') }}" rel="stylesheet">
    <link href="//{{getenv('RESOURCE_PATH')}}{{ mix('/css/reg.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//at.alicdn.com/t/font_371115_i7q3yrjs84a38fr.css">
</head>
<div class="header">
    <div class="container">
        <div class="logo"><a href="{{url('ambassador','',false)}}"><img src="//{{getenv('RESOURCE_PATH')}}/img/logo.png" alt="logo"></a></div>
        <div class="right">
            @if($user == null || !isset($user))
                @if(isset($code))
                    <a href="{{url('register', '', false)}}?code={{$code}}" class="logout">Join our ambassador program</a>
                @else
                    <a href="{{url('register', '', false)}}" class="logout">Join the Ambassador Program</a>
                @endif
                <a href="{{url('login', '', false)}}" class="logout">Log in</a>
            @else
                <a href="{{url('user-center', '', false)}}" class="">My Profile</a>
                <a href="{{url('logout', '', false)}}" class="">Logout</a>
            @endif
        </div>
    </div>
</div>
<div class="banner ambassador-banner">
    {{--@if($user == null || !isset($user))
        <div class="join-btn btn-area" onclick="join()">Join the community groups</div>
        @else
        <div class="join-btn btn-area"><a href="https://www.facebook.com/groups/seekingdawnna/" target="_blank">Join the community groups</a></div>
    @endif--}}
</div>
<div class="ambassador-rank">
    <div class="container">
        <div class="rank-area  text-center">
            <div class="title">AMBASSADOR RANKING</div>
            <div class="col-md-12 col-lg-12 rank-table-head">
                <div class="col-md-4 col-lg-4 col-xs-4 col-sm-4">RANK</div>
                <div class="col-md-4 col-lg-4 col-xs-4 col-sm-4">USER NAME</div>
                <div class="col-md-4 col-lg-4 col-xs-4 col-sm-4">REFERRALS</div>
            </div>

            @foreach($points as $p)
                <div class="col-md-12 col-lg-12 rank-table-body">
                    <div class="col-md-4 col-lg-4 col-xs-4 col-sm-4 rank"><span class="iconfont icon-zuanshi"></span> Tier {{ $p->points_level }}</div>
                    <div class="col-md-4 col-lg-4 col-xs-4 col-sm-4">{{ $p->name }}</div>
                    <div class="col-md-4 col-lg-4 col-xs-4 col-sm-4">{{ $p->points }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="ambassador-loot">
    <div class="container">
        <div class=" panel">
            <div class="title"><span>REWARDS</span></div>
            <div class="text-center" style="margin-top: 50px;">
                <img src="//{{getenv('RESOURCE_PATH')}}/images/loot_logo.png" alt="" class="loot-logo" style="width: 90%;">
                <img src="//cdn.multiverseinc.com/images/loot.png" alt="" class="loot" style="width: 90%;margin-top: 45px;">
            </div>
            {{--<ul class="loot-list">
                <li class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><img src="//{{getenv('RESOURCE_PATH')}}/images/Backpack.png" alt="backpacj"></li>
                <li class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><img src="//{{getenv('RESOURCE_PATH')}}/images/Hat.png" alt="hat"></li>
                <li class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><img src="//{{getenv('RESOURCE_PATH')}}/images/Signed Poster.png" alt="Signed Poster"></li>
                <li class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><img src="//{{getenv('RESOURCE_PATH')}}/images/Standard Copy of “Seeking Dawn”.png" alt="loot"></li>
                <li class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><img src="//{{getenv('RESOURCE_PATH')}}/images/T-Shirt.png" alt="T-Shirt"></li>
                <li class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><img src="//{{getenv('RESOURCE_PATH')}}/images/Thank you letter .png" alt="Thank you letter "></li>
            </ul>
            <div class="clearfix"></div>
            <ul class="loot-content-list">
                <li class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <p>Tier 1：0 Point ≤ Your Points < 100Points</p>
                    <p>Thank you letter + “Seeking Dawn” Key-chain</p>
                </li>
                <li class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <p>Tier 2： 100Points ≤ Your Points < 200Points </p>
                    <p>Tier 1 Prizes + 11x17 Signed Poster by developer or Freeman</p>
                </li>
                <li class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <p>Tier 3： 200Points ≤ Your Points < 300Points</p>
                    <p> Tier 1 + Tier 2 Prizes + “Seeking Dawn” T-Shirt</p>
                </li>
                <li class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <p>Tier 4： 300Points ≤ Your Points < 400Points</p>
                    <p>Tier 1 + Tier 2 Prizes +“Seeking Dawn” Backpack</p>
                </li>
                <li class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <p>Tier 5： 400Points ≤ Your Points < 500Points </p>
                    <p>Tier 1 + Tier 2 + T-Shirt + Backpack + Hat</p>
                </li>
                <li class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <p>Tier 6： 500Points ≤ Your Points < 600Points </p>
                    <p>In-Game item named after them + Standard Copy of “Seeking Dawn”</p>
                </li>
                <li class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <p>Tier 6： 500Points ≤ Your Points < 600Points </p>
                    <p>Tier 6 + In-game cosmetic + Signed Poster + Backpack + T-Shirt]</p>
                </li>
                <li class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <p>Tier 8： 700Points ≤ Your Points < 800Points  <span class="special">(Ultimate Prize)</span></p>
                    <p>Tier 7 + signed Hat + Early Access / head-start + Character named
                        after you in-game + Meet & Greet with Staff/Dev Team</p>
                </li>

            </ul>
            <div class="clearfix"></div>
            <p style="padding-left: 40px;padding-top: 40px;">(*Instruction: 100Points=10Referrals、200Points=20Referrals、300Points=30Referrals   and so on)</p>--}}
        </div>
    </div>

</div>
<div class="facebook-iframe">
    <div class="container">
        <div class=" panel">
            <p class="title">LATEST NEWS  & DEVELOPMENT FROM MULTERVISE</p>
            <div class="facebook">
                <div class="fb-page"
                     data-href="https://www.facebook.com/MultiverseVR/"
                     data-tabs="timeline" data-width="500" data-height="600"
                     data-small-header="false" data-adapt-container-width="true"
                     data-hide-cover="false" data-show-facepile="true">
                    <blockquote cite="https://www.facebook.com/MultiverseVR/" class="fb-xfbml-parse-ignore">
                        <a href="https://www.facebook.com/MultiverseVR/">Multiverse Entertainment</a>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="am-footer">
    <div class="container">
        <div class="left">
            <a href="#">Terms of Service</a>|<a href="#">Privacy Policy</a>
            <p>Copyright © Multiverse Entertainment LLC</p>
        </div>
        <div class="right"></div>
    </div>
</div>
<div id="fb-root"></div>
<script src="//at.alicdn.com/t/font_371115_i7q3yrjs84a38fr.js"></script>
<script src="//{{getenv('RESOURCE_PATH')}}/js/jquery-3.2.1.js"></script>
<script src="//{{getenv('RESOURCE_PATH')}}/layer/v3.0.3/layer.js"></script>
<script>
    function  join() {
        layer.confirm('Log in to your Multiverse account, or sign up now!', {
            btn: ['Log in','Sign up'], title: 'Message'
        }, function(){
            window.location.href = "{{ url('login', '', false) }}";
        }, function(){
            @if(isset($code))
                window.location.href = "{{ url('register', '' , false) }}?code={{$code}}";
            @else
                window.location.href = "{{ url('register', '' , false) }}";
            @endif
        });
    }
</script>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=334111223669076";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>