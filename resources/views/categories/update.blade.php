@extends('layouts.app')
@section('content')
    <header class="page-header">

        <h1 class="page-title">
            Kategorijos redagavimas
        </h1>
    </header><!-- end .page-header -->

    <section id="portfolio-items" class="clearfix">
        <form method="post" action="{{route('categories.update', $category)}}">
            @method("PATCH")
            @csrf
            <article class="full-width">

                <a class="project-meta">
                    <h5 class="title">Pavadinimas</h5>
                    <input type="text" class="full-width" name="pavadinimas" value="{{$category->pavadinimas}}" required />
                </a>
                <button type="submit" class="btn btn-primary full-width">Atnaujinti</button
            </article><!-- end .one-fourth (Altered) -->
        </form>
    </section><!-- end #portfolio-items -->
@endsection
