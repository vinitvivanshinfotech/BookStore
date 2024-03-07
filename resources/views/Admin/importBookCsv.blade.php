<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('adminview.dashboardtitle') }}</title>
    @include('cdn')
</head>

<body>
    @include('Admin.layoutAdmin.navbar')
    @include('Admin.layoutAdmin.sildebar')

    <div class="container mt-5">
        <h2>{{__('labels.importBookHeaders')}}</h2>
        <form action="{{route('book.importBookPost')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="csvFile" class="form-label">Select CSV File:</label>
                <input type="file" class="form-control" id="bookDetailsCsv" name="bookDetailsCsv" >
                @if($errors->has('bookDetailsCsv'))
                    <span class="text-danger" id="bookDetailsCsvError" name="bookDetailsCsvError">{{$errors->first('bookDetailsCsv')}}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">{{__('labels.import')}}</button>
        </form>
    </div>
    @include('Admin.layoutAdmin.footer') 
</body>

</html>
