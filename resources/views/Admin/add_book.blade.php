<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('adminview.add_new_book')}}</title>
    @include('cdn')
</head>

<body>
    
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">@</span>
        <input type="text" class="form-control" placeholder="Bookname" aria-label="Bookname" aria-describedby="addon-wrapping">
    </div>
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">@</span>
        <input type="text" class="form-control" placeholder="Booktitle" aria-label="Booktitle" aria-describedby="addon-wrapping">
    </div>
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">@</span>
        <input type="text" class="form-control" placeholder="Authorname" aria-label="Authorname" aria-describedby="addon-wrapping">
    </div>
</body>

</html>