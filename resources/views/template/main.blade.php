<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes" />
    <meta name="description" content />
    <meta name="author" content />
    <title>{{ config('app.label') }} | {{ ucwords($page_title) }}</title>
    @include('template.styles')
</head>

<body class="sb-nav-fixed">
    @include('template.menu');
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            @include('template.sidebar')
        </div>
        <div id="layoutSidenav_content">
            <main>
                <input type="hidden" class="page-name" value="{{ str_replace(' ', '-', strtolower($page_title)) }}" />
                {!!$content_view!!}
            </main>
            @include('template.footer')
        </div>
    </div>
    @include('template.scripts');
</body>

</html>
