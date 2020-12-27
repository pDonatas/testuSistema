@extends('layouts.app')

@section('content')
    <header class="page-header">

        <h1 class="page-title">Kurti testą</h1>

    </header><!-- end .page-header -->

    <h4>Parašykite testo pavadinimą</h4>

    <div class="one-half">
        <p><input type="text" placeholder="Testo pavadinimas"></p>
    </div><!-- end .one-half -->

    <div class="clear"></div>

    <hr />

    <h4>Parašykite klausimą</h4>

    <div class="one-half">
        <p><input type="text" placeholder="Klausimas"></p>
    </div><!-- end .one-half -->

    <div class="clear"></div>

    <hr />

    <h4>Parašykite testo galimus atsakymus</h4>

    <div class="one-fourth">
        <p><input type="text" placeholder="Pirmas variantas"></p>
    </div><!-- end .one-third -->

    <div class="one-fourth">
        <p><input type="text" placeholder="Antras variantas"></p>
    </div><!-- end .one-third -->

    <div class="one-fourth">
        <p><input type="text" placeholder="Trečias variantas"></p>
    </div><!-- end .one-third -->

    <div class="one-fourth last">
        <p><input type="text" placeholder="Ketvirtas variantas"></p>
    </div><!-- end .one-third -->

    <div class="clear"></div>

    <hr />

    <h4>Parašykite teisingą variantą</h4>

    <div class="one-half">
        <p><input type="text" placeholder="Teisingas variantas"></p>
    </div><!-- end .one-third -->

    <div class="clear"></div>

    <hr />

    <h4>Parašykite balą už šį klausimą</h4>

    <div class="one-half">
        <p><input type="text" placeholder="Balas skiriamas už ši klausimą"></p>
    </div><!-- end .one-third -->

    <div class="clear"></div>

    <hr />

    <p><a href="kurtiTesta.html">Pridėti kitą klausimą</a></p>
    <h3 class="entry-meta"><a href="PerziuretiTestusSarasas.html">IŠSAUGOTI</a></h3>

    <div class="clear"></div>
@endsection
