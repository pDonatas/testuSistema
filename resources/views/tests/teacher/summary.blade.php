@extends('layouts.app')
@section('content')
    <header class="page-header">

        <h1 class="page-title">Atlikti testai</h1>
    </header><!-- end .page-header -->

    <section id="portfolio-items" class="clearfix">
        @foreach($tries as $try)
            <article class="one-fourth">

                <a class="project-meta">
                    <h5 class="title">{{$try->atlikimoData}}</h5>
                </a>

            </article><!-- end .one-fourth (Altered) -->

            <article class="one-fourth">
                <a class="project-meta">
                    <h5 class="title">{{App\Models\User::find($try->user_id)->vardas.' '.App\Models\User::find($try->user_id)->pavarde}}</h5>
                </a>

            </article><!-- end .one-fourth (Snow Tower) -->

            <article class="one-fourth" >

                <a class="project-meta">
                    <h5 class="title">{{ \App\Http\Helpers::countTestScore($test->id, $try->user_id) }}</h5>
                </a>

            </article><!-- end .one-fourth (Not the end) -->

            <article class="one-fourth">

                <a href="{{route('showUserTest', [$test->id, $try->user_id])}}" class="project-meta">
                    <h5 class="title">PERŽIŪRĖTI TESTĄ</h5>
                </a>

            </article><!-- end .one-fourth (Shift) -->
        @endforeach
    </section><!-- end #portfolio-items -->
@endsection
