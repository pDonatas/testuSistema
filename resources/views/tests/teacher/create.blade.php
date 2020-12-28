@extends('layouts.app')

@section('content')
    <header class="page-header">

        <h1 class="page-title">Kurti testą</h1>

    </header><!-- end .page-header -->

    <h4>Parašykite testo pavadinimą</h4>
    <div id="errors"></div>

    <div class="full-width">
        <input id="pavadinimas" type="text" placeholder="Testo pavadinimas">
    </div><!-- end .one-half -->

    <div class="clear"></div>

    <hr />

    <h4>Pasirinkite testo kūrimo būdą</h4>

    <div class="full-width">
        <select id="type" class="multi full-width">
            <option selected value="1" disabled>Pasirinkite tipą</option>
            <option value="1">Iš kategorijų</option>
            <option value="2">Nauji klausimai</option>
        </select>
    </div><!-- end .one-half -->

    <div class="clear"></div>

    <hr />

    <div id="custom-view" style="display: none;">
        <h4>Parašykite klausimą</h4>

        <div class="one-half">
            <p><input name="question" class="full-width" type="text" placeholder="Klausimas"></p>
        </div><!-- end .one-half -->
        <div class="clear"></div>
        <hr>
        <h4>Pasirinkite kategoriją</h4>
        <div class="full-width">
            <select id="type" class="multi full-width">
                <option selected disabled>Pasirinkite kategoriją</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->pavadinimas}}</option>
                @endforeach
            </select>
        </div><!-- end .one-half -->
        <div class="clear"></div>
        <hr>
        <h4>Pasirinkite tipą</h4>
        <div class="full-width">
            <select id="type" class="multi full-width">
                <option selected disabled>Pasirinkite tipą</option>
                <option value="1">Vienas pasirinkimas</option>
                <option value="2">Keli pasirinkimas</option>
                <option value="3">Atviras klausimas</option>
            </select>
        </div><!-- end .one-half -->

        <div id="answer" style="display: none;">
            <div class="clear"></div>
            <hr>
        </div>

        <h4>Parašykite balą už šį klausimą</h4>

        <div class="one-half">
            <p><input type="text" placeholder="Balas skiriamas už ši klausimą"></p>
        </div><!-- end .one-third -->

        <div class="clear"></div>

        <hr />

        <p><a href="kurtiTesta.html">Pridėti kitą klausimą</a></p>
        <h3 class="entry-meta"><a href="PerziuretiTestusSarasas.html">IŠSAUGOTI</a></h3>

        <div class="clear"></div>
    </div>
    <div id="custom-view-categories" style="display: none;">
        <div class="full-width">
            <select id="type" class="multi full-width" multiple>
                <option selected disabled>Pasirinkite kategorijas</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->pavadinimas}}</option>
                @endforeach
            </select>
        </div><!-- end .one-half -->

        <div class="clear"></div>

        <hr />
        <button class="full-width" style="display: none;" id="submit-btn">Patvirtinti</button>
    </div>
    <input type="hidden" id="user" value="{{\Illuminate\Support\Facades\Auth::id()}}">

@endsection

@section('js')
    <script>
        let viewType = 0;
        $(document).on('selected-0', function (item) {
            let target = $(item.target);
            let id = target.attr('data-id');
            viewType = id;

            if (id == 1) // Kategorijos
            {
                $('#custom-view-categories').show();
                $('#custom-view').hide();
            } else { // Custom kūrimas
                $('#custom-view').show();
                $('#custom-view-categories').hide();
            }
            $('#submit-btn').show();
        })

        $('#submit-btn').on('click', function () {
            switch (viewType) {
                case "1":
                    let values = value[1];
                    let name = $('#pavadinimas').val();
                    let user = $('#user').val();
                    if (values.length > 0 && name.length > 0 && user.length > 0) {
                        $.ajax({
                            url: '/api/test/create',
                            type: 'POST',
                            data: {
                                category: values,
                                pavadinimas: name,
                                destytojas: user
                            }
                        }).success(function (data) {
                            window.location.href = "/tests/all";
                        }).error(function (e) {
                            $('#errors').html("<strong>Klaida</strong> Iškilo nenumatyta klaida!");
                        });
                    } else {
                        $('#errors').html("<strong>Klaida</strong> Ne visi laukai užpildyti!");
                    }
                    break;
                case "2":
                    break;
            }
        })
    </script>
@endsection
