@extends('layouts.app')
@section('content')
    <header class="page-header">

        <h1 class="page-title">
            Sukurtos kategorijos
            <span class="right"><a href="{{route('categories.create')}}"><button class="btn btn-parimary">Sukurti</button></a></span>
        </h1>
    </header><!-- end .page-header -->

    <section id="portfolio-items" class="clearfix">
        @foreach($categories as $category)
            <article class="one-fourth">

                <a class="project-meta">
                    <h5 class="title">Pavadinimas: {{$category->pavadinimas}}</h5>
                </a>

            </article><!-- end .one-fourth (Altered) -->

            <article class="one-fourth" >

                <a class="project-meta">
                    <h5 class="title">Priklauso {{ \App\Http\Helpers::countQuestionsInCategory($category->id) }} klausimų</h5>
                    <span class="right"><a href="{{route('categories.select')}}"><button class="btn btn-parimary">Prsikirti</button></a></span>
                </a>

            </article><!-- end .one-fourth (Not the end) -->

            <article class="one-fourth">

                <a href="{{route('categories.edit', $category->id)}}" class="project-meta">
                    <h5 class="title">Redaguoti</h5>
                </a>

            </article><!-- end .one-fourth (Shift) -->

            <article class="one-fourth">

                <a href="{{route('categories.destroy', $category->id)}}" class="project-meta">
                    <h5 class="title">Ištrinti</h5>
                </a>

            </article><!-- end .one-fourth (Shift) -->
        @endforeach
    </section><!-- end #portfolio-items -->
@endsection
