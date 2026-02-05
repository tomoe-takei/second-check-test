<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>mogitate</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <!--各ページのcss読み込み-->
</head>

<body>
    <header class="header">
      mogitate
    </header>

  <main>
    <!--ここが各ページによって異なります-->
    @yield('content')
  </main>

</body>

</html>
