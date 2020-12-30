@extends('layouts.app')

@section('content')
    <header class="page-header">

        <h1 class="page-title">Kurti testą</h1>

    </header><!-- end .page-header -->

    <h4>Parašykite testo pavadinimą</h4>
    <div id="errors"></div>

    <div class="full-width">
        <input class="full-width" id="pavadinimas" type="text" placeholder="Testo pavadinimas">
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

    <div class="clear"></div>

    <hr />
    <div id="customQuestions" style="display: none;">
        <div id="placeForJs"></div>
        <p><a onclick="addView()">Pridėti kitą klausimą</a></p>
        <h3 class="entry-meta"><button class="full-width" id="submit">IŠSAUGOTI</button></h3>

        <div class="clear"></div></div>
    <input type="hidden" id="user" value="{{\Illuminate\Support\Facades\Auth::id()}}">

@endsection

@section('js')
    <script>
        let current_q = 1;
        let viewType = 0;
        $(document).on('selected-0', function (item) {
            let target = $(item.target);
            let id = target.attr('data-id');
            viewType = id;

            if (id == 1) // Kategorijos
            {
                $('#custom-view-categories').show();
                removeViews();
            } else { // Custom kūrimas
                addView();
                $('#customQuestions').show();
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

        function removeViews() {
            for (let i = 0; i < current_q; i++) {
                $('#q'+current_q).remove();
            }
            $('#customQuestions').hide();
            current_q = 1;
        }

        function addView() {
            $('#placeForJs').append('<div class="custom-view" id="q'+current_q+'">\n' +
                '        <h4>Parašykite klausimą</h4>\n' +
                '\n' +
                '        <div class="full-width">\n' +
                '            <p><input name="question-'+current_q+'" class="full-width" type="text" placeholder="Klausimas"></p>\n' +
                '        </div><!-- end .one-half -->\n' +
                '        <div class="clear"></div>\n' +
                '        <hr>\n' +
                '        <h4>Pasirinkite kategoriją</h4>\n' +
                '        <div class="full-width">\n' +
                '            <select name="category-'+current_q+'" class="multi full-width">\n' +
                '                <option selected disabled>Pasirinkite kategoriją</option>\n' +
                '                @foreach($categories as $category)\n' +
                '                    <option value="{{$category->id}}">{{$category->pavadinimas}}</option>\n' +
                '                @endforeach\n' +
                '            </select>\n' +
                '        </div><!-- end .one-half -->\n' +
                '        <div class="clear"></div>\n' +
                '        <hr>\n' +
                '        <h4>Pasirinkite tipą</h4>\n' +
                '        <div class="full-width">\n' +
                '            <select name="question_type-'+current_q+'" class="multi full-width">\n' +
                '                <option selected disabled>Pasirinkite tipą</option>\n' +
                '                <option value="1">Vienas pasirinkimas</option>\n' +
                '                <option value="2">Keli pasirinkimas</option>\n' +
                '                <option value="3">Atviras klausimas</option>\n' +
                '            </select>\n' +
                '        </div><!-- end .one-half -->\n' +
                '\n' +
                '        <h4>Parašykite galimus ataskymus (skirkite kabliataskiais)</h4>\n' +
                '        <div class="full-width">\n' +
                '            <textarea class="full-width" name="question_answers-'+current_q+'"></textarea>\n' +
                '        </div><!-- end .one-half -->\n' +
                '        <h4>Parašykite teisingus ataskymus (skirkite kabliataskiais)</h4>\n' +
                '        <div class="full-width">\n' +
                '            <textarea class="full-width" name="question_correct_answers-'+current_q+'"></textarea>\n' +
                '        </div><!-- end .one-half -->\n' +
                '\n' +
                '        <h4>Parašykite balą už šį klausimą</h4>\n' +
                '\n' +
                '        <div class="full-width">\n' +
                '            <p><input type="number" class="full-width" name="score-'+current_q+'" placeholder="Balas skiriamas už ši klausimą"></p>\n' +
                '        </div><!-- end .one-third -->\n' +
                '\n' +
                '        <div class="clear"></div>\n' +
                '\n' +
                '        <hr />\n' +
                '    </div>')

            multiSelect();
            current_q++;
        }

        $('#submit').on('click', function(e) {
            e.stopPropagation();
            let data = [];
            let items = parseInt(current_q) - 1;
            console.log(items);
            for (let i = 1; i <= items; i++) {
                let item = {
                    question: $('input[name="question-' + i + '"]').val(),
                    category: $('input[name="category-' + i + '"]').val(),
                    type: $('input[name="question_type-' + i + '"]').val(),
                    answers: $('textarea[name="question_answers-' + i + '"]').val(),
                    correct: $('textarea[name="question_correct_answers-' + i + '"]').val(),
                    score: $('input[name="score-' + i + '"]').val(),
                };
                data.push(item);
            }

            console.log(data);

            $.ajax({
               url: '/api/questions/create',
               type: "POST",
               data: {
                   data: data,
                   test: {
                       user: $('#user').val(),
                       name: $('#pavadinimas').val()
                   }
               }
            }).success(function(response) {
                window.location.href = "/tests/all";
            }).error(function (e) {
                console.error(e);
            });
            console.log(data);
        });
    </script>
@endsection
