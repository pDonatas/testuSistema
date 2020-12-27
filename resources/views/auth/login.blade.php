@extends('layouts.app')

@section('content')
    @if(\Illuminate\Support\Facades\Session::has('error'))
        <div class="alert alert-danger">
            <strong>Klaida</strong> {{\Illuminate\Support\Facades\Session::get('error')}}
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <article class="entry clearfix">
            <h1 class="title">Vartotojo prisijungimas</h1>
            <p>ĮVESKITE PAŠTO ADRESĄ:</p>
            <p><input name="pastas" type="email" required placeholder="pašto adresas"></p>
            <p>ĮVESKITE SLAPTAŽODĮ:</p>
            <p><input type="password" name="slaptazodis" required placeholder="slaptažodis"></p>
        </article>
        <article class="entry-image">
            <button type="submit" class="btn btn-primary">
                Prisijunk
            </button>
        </article>
    </form>
    <article class="entry-image">
        <p>Neturi paskyros?</p>
        <p><a href="{{route('register')}}">REGISTRUOKIS</a></p>
    </article>
@endsection
