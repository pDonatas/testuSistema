<!DOCTYPE html>

<!--[if IE 7]>                  <html class="ie7 no-js" lang="en">     <![endif]-->
<!--[if lte IE 8]>              <html class="ie8 no-js" lang="en">     <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" lang="en">  <!--<![endif]-->

<head>
    <base href="{{env('APP_URL')}}">
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>ŽINIŲ TESTAVIMO SISTEMA</title>

    <meta name="description" content="">
    <meta name="author" content="">

    <!--[if !lte IE 6]><!-->
    <link rel="stylesheet" href="{{asset('css/style.css')}}" media="screen" />

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,300,800,700,400italic|PT+Serif:400,400italic" />

    <link rel="stylesheet" href="{{asset('css/fancybox.min.css')}}" media="screen" />

    <link rel="stylesheet" href="{{asset('css/video-js.min.css')}}" media="screen" />

    <link rel="stylesheet" href="{{asset('css/audioplayerv1.min.css')}}" media="screen" />
    <!--<![endif]-->

    <!--[if lte IE 6]>
    <link rel="stylesheet" href="//universal-ie6-css.googlecode.com/files/ie6.1.1.css" media="screen, projection">
    <![endif]-->

    <!-- HTML5 Shiv + detect touch events -->
    <script src="{{asset('js/modernizr.custom.js')}}"></script>

    <!-- HTML5 video player -->
    <script src="{{asset('js/video.min.js')}}"></script>
    <script>_V_.options.flash.swf = '{{asset('js/video-js.swf')}}';</script>
</head>
<body>

<header id="header" class="container clearfix">

    <nav id="main-nav">

        <ul>
            <li class="current">
                <a href="/" data-description="">Pagrindinis</a>
                @guest
                <ul>
                    <li><a href="{{route('login')}}">Prisijungti į studento/dėstytojo aplinką</a></li>
                </ul>
                @endguest
            </li>
            @auth
            <li>
                <a href="#" data-description="">Meniu</a>
                @if(\Illuminate\Support\Facades\Auth::user()->tipas >= 2)
                    <ul>
                        <li><a href="{{route('tests.create')}}">Kurti testą</a></li>
                        <li><a href="/tests/all">Peržiūrėti sukurtus testus</a></li>
                        <li><a href="{{route('categories.index')}}">Kategorijų valdymas</a></li>
                    </ul>
                @else
                    <ul>
                        <li><a href="{{route('tests.index')}}">Atlikti testą</a></li>
                        <li><a href="{{route('tests.done')}}">Peržiūrėti atliktus testus</a></li>
                    </ul>
                @endif
            </li>
            @endauth
        </ul>

    </nav><!-- end #main-nav -->

</header><!-- end #header -->

<section id="content" class="container clearfix">

    @yield('content')

</section><!-- end #content -->

<footer id="footer" class="clearfix">

    <div class="container">

        <div class="three-fourth">

            <nav id="footer-nav" class="clearfix">

                <ul>
                    <li><a href="/">Pagrindinis</a></li>
                </ul>

            </nav><!-- end #footer-nav -->

            <ul class="contact-info">
                <li class="address">Adresas</li>
                <li class="phone">(123) 456-7890</li>
                <li class="email"><a>contact@companyname.com</a></li>
            </ul><!-- end .contact-info -->

        </div><!-- end .three-fourth -->

    </div><!-- end .container -->

</footer><!-- end #footer -->

<!--[if !lte IE 6]><!-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!--[if lt IE 9]> <script src="js/selectivizr-and-extra-selectors.min.js"></script> <![endif]-->
<script src="{{asset('js/jquery.ui.widget.min.js')}}"></script>
<script src="{{asset('js/respond.min.js')}}"></script>
<script src="{{asset('js/jquery.easing-1.3.min.js')}}"></script>
<script src="{{asset('js/jquery.smartStartSlider.min.js')}}"></script>
<script src="{{asset('js/jquery.jcarousel.min.js')}}"></script>
<script src="{{asset('js/jquery.cycle.all.min.js')}}"></script>
<script src="{{asset('js/jquery.touchSwipe.min.js')}}"></script>
<!--<![endif]-->
@yield('js')
</body>
</html>
