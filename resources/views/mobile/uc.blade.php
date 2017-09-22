<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>Multiverse Entertainment LLC | User Center</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="Welcome to Multiverse Entertainment LLC, a professional virtual reality game development and publishing company.">
    <meta name="DC.title" content="Home">
    <meta name="robots" content="index,follow">
    <meta name="author" content="EmilWong">
    <link rel="shortcut icon" type="image/x-icon" href="//{{getenv('RESOURCE_PATH')}}/favicon.ico" media="screen" />
    <link href="//{{getenv('RESOURCE_PATH')}}/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet">
    <link href="//{{getenv('RESOURCE_PATH')}}{{ mix('/css/m.css') }}" rel="stylesheet">
    <link href="//{{getenv('RESOURCE_PATH')}}{{ mix('/css/m-uc.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="http://at.alicdn.com/t/font_371115_i7q3yrjs84a38fr.css">
</head>
<body>
<div class="header">
    <div class="container">
        <div class="logo"><img src="//{{getenv('RESOURCE_PATH')}}/img/logo.png" alt="logo"></div>
        <div class="right">
            <a href="{{url('ambassador', '', true)}}" class="">Home Page</a>
            <a href="{{url('logout', '', true)}}" class="logout">Logout</a>
        </div>
    </div>
</div>
<div class="uc-content">
    <div class="container">
        <div class="panel">
            <div class="uc-container">
                <div class="profile">
                    @if($user->avatar_original)
                        <img src="{{ $user->avatar_original }}" alt="profile">
                    @else
                        <img src="//{{getenv('RESOURCE_PATH')}}/img/headimg.png" alt="profile">
                    @endif
                    <p class="name">{{ $user->name }}</p>
                </div>
                <ul class="reward-list">
                    <p class="text-center">Have not earned rewards yet.</p>
                    {{--<li><img src="//{{getenv('RESOURCE_PATH')}}/img/game1.png" alt=""></li>
                    <li><img src="//{{getenv('RESOURCE_PATH')}}/img/game1.png" alt=""></li>
                    <li><img src="//{{getenv('RESOURCE_PATH')}}/img/game1.png" alt=""></li>--}}
                </ul>
                <p class="title">Welcome home, track your progress here!</p>
                <div class="main-table">
                    <div class=""><a href="https://www.facebook.com/groups/seekingdawnna/" target="_blank">Join the community groups</a></div>
                    <div class="">
                        <p class="title">Quests</p>
                        <p>1. Gain 10 points for referring your first friend</p>
                        <p>2. Gain 5 points for liking our Facebook Page</p>
                        <p>3. Gain 5 point for "joining" our Discord group</p>
                        <p>4. Gain 5 points for joining our community group</p>
                        <p>5. Gain 5 points for following our Twitter Page</p>
                    </div>
                    <div class="">
                        <p class="title">Invite friends</p>
                        <div>
                        <input type="text" value="{{ url('ambassador') }}/{{ $point->referral_code }}" readonly id="link">
                        <button id="copy" class="refer" onclick="copy('link', 'copy')">Copy</button>
                        </div>
                        <p>The six digits "<span class="special-text">{{ $point->referral_code }}</span>" on the link are a referral code</p>
                    </div>
                </div>
                <p class="title">Recommended friends</p>
                <ul class="friends">
                    @if(count($friends)===0)
                        <p>No recommendation of friends.</p>
                        @else
                        @foreach($friends as $friend)
                            <li><img src="//{{getenv('RESOURCE_PATH')}}/img/headimg.png" alt=""><p>{{ $friend->name }}</p></li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="rank">Rank: {{ $rank }}</div>
        </div>
    </div>
</div>
<div class="uc-footer">
    <div class="container">
        <p class="social_media">
            <a href="https://www.facebook.com/MultiverseVR"><i class="iconfont icon-facebookf"></i></a>
            <a href="https://twitter.com/VRmultiverse"><i class="iconfont icon-twitter"></i></a>
            <a href="https://discordapp.com/invite/3ECGtyR"><i class="iconfont icon-discord"></i></a>
        </p>
        </p>
        <div class="left">
            <a href="#">Terms of Service</a>|<a href="#">Privacy Policy</a>
            <p>Copyright © Multiverse Entertainment LLC</p>
        </div>
    </div>
</div>
</body>
<script src="//{{getenv('RESOURCE_PATH')}}/js/jquery-3.2.1.js"></script>
<script src="//{{getenv('RESOURCE_PATH')}}/bootstrap/3.3.7/js/bootstrap.js"></script>
<script>
    function copy(copytargetid,copybtnid){
        var cpt = document.getElementById(copytargetid);
        var cpb = document.getElementById(copybtnid);
        $(cpt).focus();
        $(cpt).select();
        try{
            if(document.execCommand('copy', false, null)){
                $(cpb).tooltip({title:"copied!", placement: "bottom", trigger: "manual"});
                $(cpb).tooltip('show');
                cpb.onmouseout=function(){$(cpb).tooltip('destroy')};
            } else{
                $(cpb).tooltip({title:"failed!", placement: "bottom", trigger: "manual"});
                $(cpb).tooltip('show');
                cpb.onmouseout=function(){$(cpb).tooltip('destroy')};
            }
        } catch(err){
            $(cpb).tooltip({title:"failed!", placement: "bottom", trigger: "manual"});
            $(cpb).tooltip('show');
            cpb.onmouseout=function(){$(cpb).tooltip('destroy')};
        }
    }
</script>
<script src="http://at.alicdn.com/t/font_371115_i7q3yrjs84a38fr.js"></script>
</html>