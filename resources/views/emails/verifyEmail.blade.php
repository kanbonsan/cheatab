<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<body>
    <h1>CHEATA(チータ)</h1>
    <p>{{$data["name"]}} さん、ユーザー登録していただきありがとうございます。</p>

    <p>メールアドレスを確認しました。本登録のために次のコードを入力してください。</p>
    
    <p>コード: {{$data["verify_key"]}}</p>

    <p>登録時刻: {{$data["datetime"]}}</p>
</body>


</html>