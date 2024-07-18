<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>@yield('title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    @include('layouts.base._head')

</head>

<body >

    <div class="main-wrapper">

        @include('layouts.base._header')
        
        @include('layouts.base._aside')

        @yield('content')
        
    </div>

    @include('layouts.base._script')

</body>
</html>
