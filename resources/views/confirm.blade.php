@extends('master')

@section('title', '確認')

@section('content')
    <table border="1">
        <tr>
            <th>value1</th>
            <td>{{$params['value1']}}</td>
        </tr>
        <tr>
            <th>value2</th>
            <td>{{$params['value2']}}</td>
        </tr>
        <tr>
            <th>value3</th>
            <td>{{$params['value3']}}</td>
        </tr>
    </table>
    <form method="post" action="{{route('register',['token'=>$token])}}">
        @csrf
        <button type="submit">登録</button>
    </form>
    <a href="{{route('input',['token'=>$token])}}">入力画面へ戻る</a>
@endsection
