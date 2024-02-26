<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('adminview.add_new_book')}}</title>
    @include('cdn')
</head>

<body>
    @include('Admin.layoutAdmin.navbar')
    @include('Admin.layoutAdmin.sildebar')
    <form action="{{route('save.books')}}" method="post" enctype="multipart/form-data">
        @csrf
        @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <div class="row g-2">
            <div class="col-md mb-3">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="" name="book_name">
                    <label for="floatingInput">{{__('adminlabel.book_name')}}</label>
                </div>
                @error('book_name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-md mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingInput" placeholder="" name="book_title">
                    <label for="floatingInput">{{__('adminlabel.book_title')}}</label>
                </div>
                @error('book_title')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="col-md mb-3">
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="" name="author_name">
                <label for="floatingInput">{{__('adminlabel.author_name')}}</label>
            </div>
            @error('author_name')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="col-md mb-3">
            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInputGrid" placeholder="" name="author_email">
                <label for="floatingInputGrid">{{__('adminlabel.author_email')}}</label>
            </div>
            @error('author_email')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <select class="form-select" id="floatingSelectGrid" name="book_edition">
                <option selected>{{__('adminlabel.none')}}</option>
                <option value="1">{{__('adminlabel.book_edition_1')}}</option>
                <option value="2">{{__('adminlabel.book_edition_2')}}</option>
                <option value="3">{{__('adminlabel.book_edition_3')}}</option>
            </select>
            @error('book_edition')
            <span class="text-danger">{{$message}}</span>
            @enderror
            <label for="floatingSelectGrid">{{__('adminlabel.book_edition')}}</label>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" plbook_edition_aceholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="description"></textarea>
            <label for="floatingTextarea3">{{__('adminlabel.book_description')}}</label>
            @error('description')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="input-group mb-3">
            <input type="file" class="form-control" id="inputGroupFile02" name="book_cover">
            @error('book_cover')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">{{__('adminlabel.book_amount')}}</span>
            <input type="text" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" name="book_price">
            @error('book_price')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <select class="form-select" id="floatingSelectGrid" name="book_language">
                <option selected>{{__('adminlabel.none')}}</option>
                <option value="Gujarati">{{__('adminlabel.book_language_gujarati')}}</option>
                <option value="Hindi">{{__('adminlabel.book_language_hindi')}}</option>
                <option value="English">{{__('adminlabel.book_language_english')}}</option>
            </select>
            <label class="floatingSelectGrid">{{__('adminlabel.book_language')}}</label>
            @error('book_language')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <select class="form-select" id="floatingSelectGrid" name="book_type">
                <option selected>{{__('adminlabel.none')}}</option>
                <option value="Potery">{{__('adminlabel.book_type_potery')}}</option>
                <option value="Drama">{{__('adminlabel.book_type_drama')}}</option>
                <option value="Mystery">{{__('adminlabel.book_type_mystery')}}</option>
                <option value="Thriller">{{__('adminlabel.book_type_thriller')}}</option>
                <option value="Comedy">{{__('adminlabel.book_type_comedy')}}</option>
                <option value="Religion and Spirituality">{{__('adminlabel.book_type_religion_and_spirituality')}}</option>
                <option value="Philosophy">{{__('adminlabel.book_type_philosophy')}}</option>
            </select>
            <label class="floatingSelectGrid">{{__('adminlabel.book_type')}}</span>
                @error('book_type')
                <span class="text-danger">{{$message}}</span>
                @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="submit" class="btn btn-info" id="addBookForm" name="addBookForm" value="Add Book">
        </div>
    </form>
</body>
<script>
    // $(document).ready(function() {
    //     $('#addBookForm').click(function() {
    //         add();
    //     });

    //     function add() {
    //         console.log("ok");
    //         Swal.fire('Hello');
    //     }
    // });
</script>


</html>