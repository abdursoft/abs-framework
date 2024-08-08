@extends('components/layout')
@title(Register form in layout page)
@export(body)
<h3>Hello text4</h3>
<div>
    <h4>Lorem Text</h4>
    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dignissimos explicabo, quod quibusdam qui accusantium laborum incidunt unde officiis veniam sunt placeat? Nulla illo, molestiae nam ratione numquam quod pariatur quo optio nobis porro unde eius natus quis earum quam in.</p>
</div>

{{$errors}}

<form action="/action" method="post" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name" value="">
    <input type="text" name="phone">
    <input type="file" name="file" id="">
    <input type="submit" value="submit">
</form>
@endExport

@export(content)
<h3>Content Body</h3>
@endExport