
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New order received</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            display: flex;
            /* Use flexbox to align content */
            justify-content: space-between;
            /* Distribute content evenly between the left and right sides */
            padding: 20px;
            /* Add some padding for spacing */
        }

        .invoice-details {
            flex: 1;
            /* Take up remaining space */
            padding-right: 20px;
            /* Add some right padding */
        }

        /* Table styles */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        /* Table bordered styles */
        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        /* Additional styles */
        .text-primary {
            color: #007bff !important;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
    </style>
</head>

<body>


    <h3>{{ __('labels.order_id') }} : {{ $data[0]['id'] ?? '' }}</h3>

    <h5 class="card-title">{{ __('labels.order_placed_on') }} :
        {{ \Carbon\Carbon::parse($data[0]['created_at'] ?? '')->format('d-m-Y') }}</h5>

    <h2>{{ __('labels.customer_name') }} : {{ $data[0]['first_name'] ?? '' }} {{ $data[0]['last_name'] ?? '' }}</h2>

    <p><strong>{{ __('labels.email') }} : </strong> {{ $data[0]['email'] ?? '' }}</p>
    <p><strong>{{ __('labels.phone_number') }} : </strong> {{ $data[0]['phone_number'] ?? '' }}</p>

    <h2>{{ __('labels.shipment_address') }}</h2>

    <p><strong>{{ __('labels.address') }} : </strong>{{ $data[0]['address'] ?? '' }}</p>
    <p><strong>{{ __('labels.city') }} : </strong> {{ $data[0]['city'] ?? '' }}</p>
    <p><strong>{{ __('labels.state') }} : </strong> {{ $data[0]['state'] ?? '' }}</p>
    <p><strong>{{ __('labels.pincode') }} : </strong> {{ $data[0]['pincode'] ?? '' }}</p>

    <table class="table table-bordered mt-3 mb-3">
        <thead>
            <tr>
                <th scope="col">{{ __('labels.book_name') }}</th>
                <th scope="col">{{ __('labels.book_edition') }}</th>
                <th scope="col">{{ __('labels.book_price') }}</th>
                <th scope="col">{{ __('labels.book_discount') }}</th>
                <th scope="col">{{ __('labels.quantity') }}</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalDiscount = 0;
                $totalPrice = 0;
            @endphp
            @foreach ($data as $bookInfo)
                <tr>
                    <td>{{ $bookInfo['book_name'] }}</td>
                    <td>{{ $bookInfo['book_edition'] }}</td>
                    <td>{{ $bookInfo['book_price'] }}</td>
                    <td>{{ $bookInfo['book_discount'] }}</td>
                    <td>{{ $bookInfo['book_quantity'] }}</td>
                </tr>
                @php
                    $totalPrice += $bookInfo['book_price'] * $bookInfo['book_quantity'];
                    $totalDiscount += $bookInfo['book_discount'] * $bookInfo['book_quantity'];
                @endphp
            @endforeach
            <tr>
                <td><b class="text-primary">{{ __('labels.total') }}</b></td>
                <td> - </td>
                <td><b class="text-primary">{{ $totalPrice }}</b></td>
                <td><b class="text-primary">{{ $totalDiscount }}</b></td>
                <td><b class="text-primary">{{ $data[0]['book_total_quantity'] ?? '' }}</b></td>
            </tr>


        </tbody>
    </table>
    <br>

    <b>{{ __('labels.payable_amount') }} : {{ $data[0]['book_total_price'] ?? '' }}</b>
    <br /><br />
</body>

</html>

