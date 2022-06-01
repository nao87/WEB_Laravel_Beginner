@extends('layout')
{{--メインコンテンツ--}}
@section('contets')

       @if($errors->any())
           <div>
               @foreach($errors->all() as $errors)
               {{$errors}}<br>
               @endforeach
           </div>
       @endif
        <form action="/test/input" method="POST">
            @csrf
            email:<input name="email" value="{{old('email')}}"><br>
            パスワード:<input type="password" name="password"><br>
            <button>送信する</button>
        </form>
@endsection