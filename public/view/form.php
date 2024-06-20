<h3> PHP Form</h3>
<form action="/action" method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Name"> <br />
    <input type="text" name="email" placeholder="jhon@gmail.com"> <br />
    <input type="text" name="mobile" placeholder="0198541251"> <br />
    <input type="text" name="bio" placeholder="Your bio"> <br />
    <input type="file" name="file"> <br />
    <input type="submit" name="submit" value="Submit">
</form>
<h2>
    {{$page_title}}
</h2>

{{ $id }}

@if(2==21)
    <h3>Equal</h3>
    @elseif(3==3)
        <h1>Else Done</h1>
    @else
        <h3>Not Equal</h3>
@endif

<!-- @foreach($numbers as $number)
    <h4>{{ $number }}</h4>
@endforeach -->


@switch('hello')
    @case(3)
        @echo('nice match')
        @break;
    @case(hello)
        @echo('Hello World')
        @break
    @default
        @echo('nothing')
@endswitch