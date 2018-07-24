@extends('master')

@section('title', '入力')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{route('validate_input',['token'=>$token])}}">
        @csrf
        value1:<input type="text" name="value1" value="{{old('value1') ?? $params['value1']}}"><br/>
        value2:<input type="text" name="value2" value="{{old('value2') ?? $params['value2']}}"><br/>
        value3:<input type="text" name="value3" value="{{old('value3') ?? $params['value3']}}"><br/>
        <button type="submit">送信</button>
    </form>
@endsection
