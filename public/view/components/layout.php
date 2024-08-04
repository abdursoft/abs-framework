<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@title@</title>
    @style@
    @script@
    @meta@
</head>
<body class="abs-view">
    @addView('components/header')
    @import(content)
    <img src="{{storage('upload/1719244547jl23jirn8jtotkl1j9gv2k3mu33sk2fo.png')}}" alt="" width="400px" height="200px">
    @import(body)
    @postView('components/footer')
</body>
</html>
