<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('adminlabel.showallbook')}}</title>

    @include('cdn')
</head>

<body>
    @include('Admin.layoutAdmin.navbar')
    @include('Admin.layoutAdmin.sildebar')
    <div class="form-floating mb-3">
        <select class="form-select optionselect" name="Order Status">
            <option value="None">None</option>
            <option value="Potery">Potery</option>
            <option value="Drama">Drama</option>
            <option value="Mystery">Mystery</option>
            <option value="Thriller">Thriller</option>
            <option value="Comedy">Comedy</option>
            <option value="Religion and Spirituality">Religion and Spirituality</option>
            <option value="Comedy">Comedy</option>
        </select>
        <label class="floatingSelectGrid">{{__('adminlabel.book_type')}}</span>
    </div>
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
        </thead>
    </table>
    <script>
        $(document).ready(function() {

            $('.optionselect').change(function() {
                var categories = $(this).val();
                // console.log(categories)
                $.ajax({
                    type: "POST",
                    url: "{{route('category.store')}}",
                    data: {
                        categories: categories,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(response) {
                        console.log('error');
                        alert(response.error);
                    }
                });
            });
        });
    </script>
</body>

</html>