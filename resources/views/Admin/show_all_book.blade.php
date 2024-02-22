<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    @include('cdn')
</head>

<body>
    @include('Admin.layoutAdmin.navbar')
    @include('Admin.layoutAdmin.sildebar')
    <table class="table table-bordered table-hover" id="books_list" name="books_list">
        @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <thead>
            <th>{{__('adminlabel.no')}}</th>
            <th>{{__('adminlabel.author_name')}}</th>
            <th>{{__('adminlabel.book_title')}}</th>
            <th>{{__('adminlabel.author_name')}}</th>
            <th>{{__('adminlabel.author_email')}}</th>
            <th>{{__('adminlabel.book_edition')}}</th>
            <th>Book Cover</th>
            <th>{{__('adminlabel.book_language')}}</th>
            <th>{{__('adminlabel.book_type')}}</th>
            <th>{{__('adminlabel.book_amount')}}</th>
            <th>{{__('adminlabel.action')}}</th>
        </thead>
        <tbody>
            @foreach ($all_books as $all_book )

            <tr>
                <td>{{$loop->index +1}}</td>
                <td>{{$all_book->book_name}}</td>
                <td>{{$all_book->book_title}}</td>
                <td>{{$all_book->author_name}}</td>
                <td>{{$all_book->author_email}}</td>
                <td>{{$all_book->book_edition}}</td>
                @if(empty($all_book->book_cover))
                <td>
                    <h6>Image Not Found</h6>
                </td>
                @endif
                <td><img src="{{ Storage::disk(config('constant.FILESYSTEM_DISK'))->url($all_book->book_cover) }}" width="120" height="50" /></td>
                <td>{{$all_book->book_language}}</td>
                <td>{{$all_book->book_type}}</td>
                <td>{{$all_book->book_price}}</td>
                <td>
                    <a href="{{route('edit.book',$all_book->id)}}" class="btn btn-sm btn-dark">{{__('adminlabel.edit')}}</a>
                    <a href="{{route('delete.book',$all_book->id)}}" class="btn btn-sm btn-dark">{{__('adminlabel.delete')}}</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            let table = new DataTable('#books_list');

        });
    </script>
</body>

</html>