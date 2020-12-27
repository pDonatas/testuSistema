@extends('layouts.app')
@section('content')
    <header class="page-header">

        <h1 class="page-title">Atlikti testai</h1>
    </header><!-- end .page-header -->

    <section id="portfolio-items" class="clearfix">
        @foreach($tests as $test)
        <article class="one-fourth">

            <a class="project-meta">
                <h5 class="title">{{$test->created_at}}</h5>
            </a>

        </article><!-- end .one-fourth (Altered) -->

        <article class="one-fourth">
            <a class="project-meta">
                <h5 class="title">{{$test->pavadinimas}}</h5>
            </a>

        </article><!-- end .one-fourth (Snow Tower) -->

        <article class="one-fourth" >

            <a class="project-meta">
                <h5 class="title">{{ App\Models\User::find($test->destytojas)->vardas.' '.App\Models\User::find($test->destytojas)->pavarde }}</h5>
            </a>

        </article><!-- end .one-fourth (Not the end) -->

        <article class="one-fourth">

            <a href="{{route('showTest', $test->id)}}" class="project-meta">
                <h5 class="title">PERŽIŪRĖTI TESTĄ</h5>
            </a>

        </article><!-- end .one-fourth (Shift) -->
        @endforeach
    </section><!-- end #portfolio-items -->
@endsection
