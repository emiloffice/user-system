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
    <link href="//{{getenv('RESOURCE_PATH')}}{{ mix('/css/app.css') }}" rel="stylesheet">
    <link href="//{{getenv('RESOURCE_PATH')}}{{ mix('/css/uc.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//{{getenv('RESOURCE_PATH')}}/font-awesome/css/font-awesome.css" />
</head>
<body>
<div class="uc-header">
    <div class="container">
        <div class="logo"><img src="//{{getenv('RESOURCE_PATH')}}/img/logo.png" alt="logo"></div>
        <div class="right">
            <a href="{{url('ambassador', '', $HTTPS_REQUEST)}}" class="">Home Page</a>
            <a href="{{url('logout', '', $HTTPS_REQUEST)}}" class="logout">Logout</a>
        </div>
    </div>
</div>
<div class="uc-content">
    <div class="container">
        <div class="panel">
            <div class="uc-container">
                <p class="title"><span class="line"></span>Welcome home, track your progress here!</p>
                <div class="main-table">
                    <div class="left">
                        {{--<div class=""></div>--}}
                        <div class=""><a href="https://www.facebook.com/groups/seekingdawnna/" target="_blank">Join our ambassador program</a></div>
                        <div class="">
                            <p class="title" style="padding-top: 10px">Quests</p>
                            <p>1. Gain 10 points for referring your first friend</p>
                            @if($point->fb_status===1)
                                <p class="line-throught">2. Gain 5 points for liking our Facebook Page</p>
                                @else
                                <p>2. Gain 5 points for liking our Facebook Page</p>
                            @endif
                            @if($point->discord_status===1)
                                <p class="line-throught">3. Gain 5 point for joining our Discord group</p>
                                @else
                                <p>3. Gain 5 point for joining our Discord group</p>
                            @endif
                            @if($point->group_status===1)
                                <p class="line-throught">>4. Gain 5 points for joining our community group</p>
                                @else
                                <p>4. Gain 5 points for joining our community group</p>

                            @endif
                            @if($point->twitter_status===1)
                                <p class="line-throught">>5. Gain 5 points for following our Twitter Page</p>
                            @else
                                <p>5. Gain 5 points for following our Twitter Page</p>
                            @endif
                        </div>
                        <div class="">
                            <p class="title" >Invite friends</p>
                            <div><input type="text" value="{{ url('ambassador') }}/{{ $point->referral_code }}" readonly id="link"><button id="copy" class="refer" onclick="copy('link', 'copy')">Copy & Share</button></div>
                            <p style="padding-top: 5px">This six digit code"<span class="special-text">{{ $point->referral_code }}</span>"at the end of your referral link represents your referral code</p>
                        </div>
                    </div>

                    <div class="right">
                        <div class="profile">
                            @if($user->avatar_original)
                                <img src="{{ $user->avatar_original }}" alt="profile">
                                @else
                                <img src="//{{getenv('RESOURCE_PATH')}}/img/headimg.png" alt="profile">
                            @endif
                            <p class="name">{{ $user->name }}</p>
                            <div class="am_level">
                                <p class="level">Tier {{ $point->level }}</p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $point->progress }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $point->progress }}%">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <ul class="reward-list">
                            <p class="text-center">Have not earned rewards yet.</p>

                            {{--<li><img src="//{{getenv('RESOURCE_PATH')}}/img/game1.png" alt=""></li>
                            <li><img src="//{{getenv('RESOURCE_PATH')}}/img/game1.png" alt=""></li>
                            <li><img src="//{{getenv('RESOURCE_PATH')}}/img/game1.png" alt=""></li>--}}
                        </ul>
                    </div>
                </div>
                <p class="title"><span class="line"></span>Recommended friends</p>
                <ul class="friends">
                    @if(count($friends)===0)
                        <p>No recommended friends at this time!</p>
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
</html>