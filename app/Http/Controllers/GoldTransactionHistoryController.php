<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionHeader;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Helpers\General\DateHelper;

class GoldTransactionHistoryController extends Controller
{
    /*
        Variable 
        
        Request:
        keyword: String
        fromDate: Date (nullable)
        toDate: Date (nullable)

        Response:
        allTransactionHeader: [TransactionHeader]
    */
    public function index() {
        $request = request();
        $fromDate = $request['fromDate'] ?  DateHelper::createCarbonFromFormat(DateHelper::FRONT_END_FORMAT, $request['fromDate']) : null;
        $toDate = $request['toDate'] ?  DateHelper::createCarbonFromFormat(DateHelper::FRONT_END_FORMAT, $request['toDate']) : null;

        //TODO: adjust render page
        return Inertia::render('TransactionHistory/index',[
            'allTransactionHeader' => TransactionHeader::getTransactionHeaderByFilter(
                $request['keyword'] , 
                $fromDate, 
                $toDate
            )
            ->orderBy('created_at', 'desc')
            ->with(
                'transactionDetails.gold.shelf',
                'transactionDetails.gold.goldCaratCategory',
                'transactionDetails.gold.categories',
                'user',
                'customer'
            )->paginate(25)
        ]);

    }

    /*
        Variable 
        
        Request:

        Response:
        transactionHeader: TransactionHeader
        transactionDetails: [TransactionDetail]
    */
    public function show(TransactionHeader $transactionHeader) {
        return Inertia::render('TransactionHistory/Show/index',[
            'transactionHeader' => $transactionHeader->load(
                'transactionDetails.gold.shelf',
                'transactionDetails.gold.goldCaratCategory',
                'transactionDetails.gold.categories',
                'user',
                'customer'
            ),
            'transactionDetails' => $transactionHeader->transactionDetails->with(
                'transactionDetails.gold.shelf',
                'transactionDetails.gold.goldCaratCategory',
                'transactionDetails.gold.categories',
                'user',
                'customer'
            )->paginate(25)
        ]);
    }
}
