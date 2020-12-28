@extends('layouts.app')
@section('content')
    <header class="page-header">

        <h1 class="page-title">
            Sukurti kategoriją
        </h1>
    </header><!-- end .page-header -->
    <section id="portfolio-items" class="clearfix">
        <form id="form" method="post" action="{{route('categories.setQuestions', $id)}}">
            @csrf
            <article class="full-width">

                <h5 class="title">Klausimai</h5>
                <select class="multi full-width" name="questions[]" multiple>
                    <option value="" disabled selected>Pasirinkite klausimą</option>
                    @foreach($questions as $question)
                        <option {{$question->kategorija == $id ? 'selected' : ''}} value="{{$question->id}}">{{$question->pavadinimas}}</option>
                    @endforeach
                </select>
                <input type="hidden" name="selected" id="selected">
                <button type="submit" class="btn btn-primary full-width">Patvirtinti</button>
            </article><!-- end .one-fourth (Altered) -->
        </form>
    </section><!-- end #portfolio-items -->
@endsection

@section('js')
    <script>
        $('.btn-primary').on('click', function(e) {
            e.preventDefault();
            let selectedItems = document.getElementsByClassName('multi__li-item--selected');
            let ids = [];
            for(let i = 0; i < selectedItems.length; i++) {
                ids.push($(selectedItems[i]).attr('data-id'));
            }
            if (ids.length === 0) {
                $('.alert').remove();
                $('<div class="alert alert-danger"><strong>Klaida</strong> Nepasirinkote klausimų</div>').insertAfter('#portfolio-items');
            } else {
                $('#selected').val(ids);

                $('#form').submit();
            }
        })
        $('.multi__display').attr('type', 'button');
    </script>
@endsection
