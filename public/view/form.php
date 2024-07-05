


@if('me' === 'me')
    <h3>Equal</h3>
    @elseif(3==3)
        <h1>Else Done</h1>
    @else
        <h3>Not Equal</h3>
@endif

<h3>For loop</h3>
@for($i=0; $i < 10; $i++)
    <h2>{{ $i }}</h2>
@endfor


@switch('hello')
    @case(3)
        @echo('nice match')
        @break
    @case(hello)
        @echo('Hello World')
        @break
    @default
        @echo('nothing')
@endswitch

