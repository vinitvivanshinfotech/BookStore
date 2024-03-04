<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('adminlabel.orderbook')}}</title>
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
            <th>{{__('adminlabel.customer_name')}}</th>
            <th>{{__('adminlabel.order_id')}}</th>
            <th>{{__('adminlabel.total_amount')}}</th>
            <th>{{__('adminlabel.total_quantity')}}</th>
            <th>{{__('adminlabel.order_status')}}</th>
            <th>{{__('adminlabel.action')}}</th>


        </thead>
        <tbody id="orders">

        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            let table = new DataTable('#books_list');
            $('.optionselect').change(function() {
                var id = $(this).attr('id');
                var order_status = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{route('update.order.status')}}",
                    data: {
                        id: id,
                        order_status: order_status,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert("Status Updated Successfully");
                        } else {
                            alert("Status not Updated Successfully");
                        }
                    },
                    error: function(response) {
                        console.log('error');
                        alert(response.error);
                    }
                });

            });
            // setInterval(updateOrdersTable(), 3000);
            updateOrdersTable();

            function updateOrdersTable() {
                $.ajax({
                    type: "GET",
                    url: "{{route('order.book')}}",
                    data: "",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        printtable(data);
                    },
                    error: function(response) {
                        console.log(response.error);
                    }

                });
            }

            function printtable(data) {
                data.forEach(element => {
                    var Html = " <tr> <td> " + element['id'] + "</td><td>" + element['user']['first_name'] + element['user']['last_name'] + "</td><td> " + element['id'] + "</td><td>" + element['book_total_price'] + "</td><td>" + element['book_total_quantity'] +
                        "</td><td> <div class='form-floating mb-3'> <select class='form-select optionselect' id=" + element['id'] + " name='Order Status'> <option value='{{__('adminlabel.placed_order')}}' Placed Order</option><option value=" + element['order_status'] + "Placed Order</option></select></div>"


                        +
                        "</td><td><button class='btn btn-sm btn-info' value" + element['id'] + ">Info</button>  <button class='btn btn-sm btn-danger delete' value=" + element['id'] + ">Delete</button></td><td>";
                    $('#orders').append(Html)
                });
            }

            function clean() {
                $('#orders').empty();
            }


            $(document).on("click", ".delete", function() {

                var id = $(this).val();
                console.log(id);
                $.ajax({
                    type: "POST",
                    url: "{{route('delete.order')}}",
                    data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(response) {
                        console.log(response.success);
                        clean()
                        updateOrdersTable()
                    },
                    error: function(response) {
                        alert("Order not Deleted Successfully");
                        console.log(response.error);
                    }
                });
            });

            $(document).on("click",".edit",function(){
                var id = $(this).val();
                console.log(id);
                $.ajax({
                    type:"GET",
                    url:"{{route('orderdetails.book')}}",
                    data:{id:id},
                    success:function(data){

                    },
                    error:function(response){
                        console.log(response.error);
                    }
                })
            });

        });
    </script>

</body>

</html>