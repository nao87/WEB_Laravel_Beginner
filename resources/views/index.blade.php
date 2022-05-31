@extends('layout')
{{--メインコンテンツ--}}
@section('contets')
       <h1>ログイン</h1>
        <form action="/login" method="POST">
            email:<input name="email"><br>
            パスワード:<input type="password" name="password"><br>
            <button>ログインする</button>
        </form>
@endsection