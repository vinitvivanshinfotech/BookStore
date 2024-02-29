<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('adminview.edit_book')}}</title>
    @include('cdn')
</head>

<body>
    @include('Admin.layoutAdmin.navbar')
    @include('Admin.layoutAdmin.sildebar')
    <form action="{{route('update.book')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{$book->id}}">
        <div class="row g-2">
            <div class="col-md mb-3">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" name="book_name" value="{{$book->book_name}}">
                    <label for="floatingInput">{{__('adminlabel.book_name')}}</label>
                </div>
            </div>
            <div class="col-md mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingInput" name="book_title" value="{{$book->book_title}}">
                    <label for="floatingInput">{{__('adminlabel.book_title')}}</label>
                </div>
            </div>
        </div>
        <div class="col-md mb-3">
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" name="author_name" value="{{$book->author_name}}">
                <label for="floatingInput">{{__('adminlabel.author_name')}}</label>
            </div>
        </div>
        <div class="col-md mb-3">
            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInputGrid" name="author_email" value="{{$book->author_email}}">
                <label for="floatingInputGrid">{{__('adminlabel.author_email')}}</label>
            </div>
        </div>
        <div class="col-md">
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelectGrid" name="book_edition">
                    <option @if(in_array('None',$bookEdition)) selected @endif>{{__('adminlabel.none')}}</option>
                    <option value="1" @if(in_array('1',$bookEdition)) selected @endif>{{__('adminlabel.book_edition_1')}}</option>
                    <option value="2" @if(in_array('2',$bookEdition)) selected @endif>{{__('adminlabel.book_edition_2')}}</option>
                    <option value="3" @if(in_array('3',$bookEdition)) selected @endif>{{__('adminlabel.book_edition_3')}}</option>
                </select>
                <label for="floatingSelectGrid">{{__('adminlabel.book_edition')}}</label>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="description">{{$book->description}}</textarea>
                <label for="floatingTextarea3">{{__('adminlabel.book_description')}}</label>
            </div>
            <div>
                <div class="form-floating mb-3">
                    <img src="{{ Storage::disk(config('constant.FILESYSTEM_DISK'))->url($book->book_cover) }}" width="120" height="70" />
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile02" name="book_cover">
                <label class="input-group-text" for="inputGroupFile02">{{__('adminlabel.book_cover')}}</label>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">{{__('adminlabel.book_amount')}}</span>
                <input type="text" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" name="book_price" value="{{$book->book_price}}">
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelectGrid" name="book_language">
                    <option @if(in_array('None',$bookLanguage)) selected @endif>{{__('adminlabel.none')}}</option>
                    <option value="Gujarati" @if(in_array('Gujarati',$bookLanguage)) selected @endif>{{__('adminlabel.book_language_gujarati')}}</option>
                    <option value="Hindi" @if(in_array('Hindi',$bookLanguage)) selected @endif>{{__('adminlabel.book_language_hindi')}}</option>
                    <option value="English" @if(in_array('English',$bookLanguage)) selected @endif>{{__('adminlabel.book_language_english')}}</option>
                </select>
                <label class="floatingSelectGrid">{{__('adminlabel.book_language')}}</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="floatingSelectGrid" name="book_type">
                    <option @if(in_array('None',$bookType)) selected @endif>{{__('adminlabel.none')}}</option>
                    <option value="Potery" @if(in_array('Potery',$bookType)) selected @endif>{{__('adminlabel.book_type_potery')}}</option>
                    <option value="Drama" @if(in_array('Drama',$bookType)) selected @endif>{{__('adminlabel.book_type_drama')}}</option>
                    <option value="Mystery" @if(in_array('Mystery',$bookType)) selected @endif>{{__('adminlabel.book_type_mystery')}}</option>
                    <option value="Thriller" @if(in_array('Thriller',$bookType)) selected @endif>{{__('adminlabel.book_type_thriller')}}</option>
                    <option value="Comedy" @if(in_array('Comedy',$bookType)) selected @endif>{{__('adminlabel.book_type_comedy')}}</option>
                    <option value="Religion and Spirituality" @if(in_array('Religion and Spirituality',$bookType)) selected @endif>{{__('adminlabel.book_type_religion_and_spirituality')}}</option>
                    <option value="Philosophy" @if(in_array('Philosophy',$bookType)) selected @endif>{{__('adminlabel.book_type_philosophy')}}</option>
                </select>
                <label class="floatingSelectGrid">{{__('adminlabel.book_type')}}</span>
            </div>
            <div class="">
                <input type="submit" class="btn btn-info" value="Update Book">
            </div>
    </form>
</body>

</html>