@extends('layouts.app')

@section('content')
    @if(\Illuminate\Support\Facades\Session::has('error'))
        <div class="alert alert-danger">
            <strong>Klaida</strong> {{\Illuminate\Support\Facades\Session::get('error')}}
        </div>
    @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf
    <article class="entry clearfix">
        <h1 class="title">Vartotojo registracija</h1>
        <p>ĮVESKITE SAVO VARDĄ:</p>
        <p><input type="text" name="vardas" placeholder="vardas" required></p>
        <p>ĮVESKITE SAVO PAVARDĘ:</p>
        <p><input type="text" name="pavarde" placeholder="pavardė" required></p>
        <p>ĮVESKITE SAVO PAŠTO ADRESĄ:</p>
        <p><input type="email" name="pastas" placeholder="pašto adresas" required></p>
        <p>ĮVESKITE SAVO SLAPTAŽODĮ:</p>
        <p><input type="password" name="slaptazodis" placeholder="slaptažodis" required4></p>
    </article>
    <article class="entry-image">
        <button type="submit" class="btn btn-primary">
            Registruokis
        </button>
    </article>
    </form>
    <article class="entry-image">
        <p>Jau turi paskyrą?</p>
        <p><a href="{{route('login')}}">PRISIJUNK</a></p>
    </article>
@endsection
