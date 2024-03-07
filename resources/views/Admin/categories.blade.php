<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('adminlabel.showallbook')}}</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">


    @include('cdn')
</head>

<body>
    @include('Admin.layoutAdmin.navbar')
    @include('Admin.layoutAdmin.sildebar')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
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

            var $table = $('#book_list'),
                dataTable;
            var data = {};    

            function dataTableReload() {
                dataTable.ajax.reload();
            };

            function dataTableInit(data){

                dataTable = $table.DataTable({
                    "responsive": true,
                    "processing": true,
                    "serverSide": true,
                    "destroy": true,
                    "stateSave": true,
                    "colums":[
                        {data:'id'},
                        {data:'author_name'},
                        {data:'book_title'},
                        {data:'author_name'},
                        {data:'author_email'},
                        {data:'book_edition'},
                        {data:'book_cover'},
                        {data:'book_language'},
                    ],
                    "order": [[ 0, 'desc' ]],
                    "pageLength": 10,
                    "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
                    
                });
            }
            dataTableReload();

            $('.optionselect').change(function() {
                var categories = $(this).val();
                // console.log(categories)
                $.ajax({
                    type: "GET",
                    url: "{{route('category.store')}}",
                    data: {
                        categories: categories,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function(book_types) {
                        console.log(book_types);
                        dataTableInit(book_types);

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