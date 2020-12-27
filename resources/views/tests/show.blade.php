@extends('layouts.app')

@section('content')
    <header class="page-header">

        <h1 class="page-title">{{$questions[0]->pavadinimas}}</h1>

    </header><!-- end .page-header -->
        <section id="main">
            @foreach($questions[2]['questions'] as $question)
                <article class="entry clearfix">

                    <div class="entry-body">
                        <h1 class="title">{{$question['question']->pavadinimas}}</h1>
                        @if(count($question['answers']) > 0)
                            @foreach($question['answers'] as $answer)
                                @if ($answer == null)
                                    <p>Studento atsakymas: Neatsakyta</p>
                                @elseif (getType($answer) === "object")
                                    <p>Studento atsakymas: {{$answer->pavadinimas}}</p>
                                @else
                                    <p>Studento atsakymas: {{$answer}}</p>
                                @endif
                            @endforeach
                        @else
                            <p>Studento atsakymas: Neatsakyta</p>
                        @endif

                        @if(count($question['correctAnswers']) > 0)
                            @foreach($question['answers'] as $answer)
                                <p>Teisingas atsakymas: {{$answer->pavadinimas}}</p>
                            @endforeach
                        @else
                            <p>Teisingas atsakymas: Klausimas atviras</p>
                        @endif
                        <p>Gautas balas: {{$question['score']}}</p>

                    </div><!-- end .entry-body -->

                </article><!-- end .entry -->
            @endforeach

            <article class="clearfix">

                <div class="entry-meta">
                    <a href="{{route('tests.done')}}"><button class="btn btn-primary" type="submit">Atgal</button></a>
                </div>

            </article><!-- end .entry -->
            @if (count($questions[2]['questions']) > 2)
                <ul class="pagination">
                    <li class="prev"><a href="#">&larr; Atgal</a></li>
                    <li class="next"><a href="#">Kita &rarr;</a></li>
                </ul>@endif

        </section><!-- end #main -->

    <aside id="sidebar">

        <div class="widget">

            <h4 class="acc-trigger">
                <a href="#">Destytojas</a>
            </h4>

            <div class="acc-container">
                <div class="content">Vardas: {{$questions[1]->vardas}}<br/>Pavardė: {{$questions[1]->pavarde}}</div>
            </div>

        </div><!-- end .widget -->

    </aside><!-- end #sidebar -->
    <div style="display: none" id="currentPage"></div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            pagination(true); // Kvieciam puslapiavima
        });

        function pagination(init) {
            // Pagination
            let pages = parseInt({{count($questions[2]['questions'])}}) / 2; // Items / items per page
            let current = $('#currentPage').html();
            if (current == '') {
                $('#currentPage').html(1);
                current = $('#currentPage').html();
            }

            $('.prev').attr('data-next', parseInt($('#currentPage').html()) > 1 ? parseInt($('#currentPage').html()) - 1 : 1);
            $('.next').attr('data-next', parseInt($('#currentPage').html()) < pages ? parseInt($('#currentPage').html()) + 1 : pages);
            // Inicijavimas ( first load )
            if (init) {
                for (let i = 1; i <= pages; i++) {
                    let li = '<li data-id="' + i + '" data-next="' + i + '"><a href="#">' + i + '</a></li>';
                    $(li).insertBefore('.next');
                    if (i == current) {
                        $(".pagination").find(`[data-id='${i}']`).addClass('current');
                    }
                }
                // Kas nutinka paspaudus ant puslapio?
                $('.pagination li').on('click', function(e) {
                    e.preventDefault();
                    $('#currentPage').html($(this).attr('data-next'));
                    pagination(false);
                });
            }
            // Sitas vyksta visada
            // Nuimam senam current klases turetojui klase
            $('.current').removeClass('current');
            // Uzdedam naujam
            $(".pagination").find(`[data-id='${current}']`).addClass('current');

            // ciklas per klausimus
            $('#main').children('.entry').each(function(i) {
                let item = i + 1;
                let page = Math.round(item / 2);
                let current = $('#currentPage').html();

                $(this).attr('data-page', page);
                if (page != current) {
                    // Nerodom klausimu kurie neturi but tam puslapi
                    $(this).css("display", "none");
                } else {
                    // Rodom tik tuos kurie privalo but rodomi
                    $(this).css("display", "block");
                }
            });
        }
    </script>
@endsection
