<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content />
  <meta name="author" content />
  <title>{{ config('app.label') }} | {{ ucwords($page_title) }}</title>
  @include('landing.styles')
</head>

<body>
  <div id="layoutDefault">
    <div id="layoutDefault_content">
      <main>
        @include('landing.header')
        {!!$content_view!!}
      </main>
    </div>
    @include('template.footer')
  </div>
  @include('landing.scripts')
</body>

</html>
