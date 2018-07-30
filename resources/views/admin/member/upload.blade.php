@extends('admin/common/basic')

@section('content')

<form action ="{{url('admin/upload')}}" method = "POST" enctype="multipart/form-data" >
    @csrf
    <input type = "file" name="pics[]" multiple/>
    <input type="submit" name="submit" value ="Upload"/>

</form>


@endsection

