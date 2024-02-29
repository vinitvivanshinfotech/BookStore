<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\ShippingDetail;
use App\Jobs\SendOrderListToAdmin;
use Illuminate\Support\Facades\Log;


class sendcsvtoadmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendcsv:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command which is used to send the mail to admin  with csv file attached';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {

            $paymentBook  = ShippingDetail::join('order_details', 'order_details.id', '=', 'shipping_details.order_id')
                ->join('payment_books', 'payment_books.id', '=', 'order_details.payment_id')
                ->join('order_descripitions', 'order_descripitions.order_id', '=', 'order_details.id')
                ->join('book_details', 'book_details.id', '=', 'order_descripitions.book_id')
                ->distinct('shipping_details.order_id')
                ->whereDate('shipping_details.created_at', '=', Carbon::today())
                ->whereTime('shipping_details.created_at', '>', Carbon::now()->subHours(2))
                ->get()->toArray();
            $csvFileName = 'neworderlist.csv';
            $tempFilePath = tempnam(sys_get_temp_dir(), 'csv_') . '.csv';
            $fp = fopen($tempFilePath, 'w');

            fputcsv($fp, ['id', 'Customer Name', 'order id ', 'Total Quantity', 'Total Price', 'City', 'State', 'created_at', 'updated_at']); // Add more headers as needed

            foreach ($paymentBook as $paymentBook) {
                fputcsv($fp, [$paymentBook['id'], ($paymentBook['first_name']), $paymentBook['order_id'], $paymentBook['book_total_quantity'], $paymentBook['book_total_price'], $paymentBook['city'], $paymentBook['state'], $paymentBook['created_at'], $paymentBook['updated_at']]); // Add more fields as needed
            }
            fclose($fp);
            Log::info('test');
            $details = 'vinit.m@vivanshinfotech.com';
            dispatch(new SendOrderListToAdmin($details, ['tempFilePath' => $tempFilePath]));
            dispatch(new SendOrderListToAdmin($details, ['tempFilePath' => $tempFilePath]));
        } catch (\Exception $e) {
            Log::error('Attempt to send csv file of orderlist to admin ' . ' failed. Error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to send the csv file to admin.'], 500);
        }
    }
}
