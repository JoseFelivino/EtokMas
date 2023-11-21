<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookKeepingHeader;
use App\Models\BookKeepingDetail;
use App\Models\Shelf;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Helpers\General\CollectionHelper;
use App\Helpers\General\DateHelper;

class BookKeepingController extends Controller
{
    /*
        Variable 
        
        Request:

        Response:
        allBookKeepingHeaderBasedOnShelf: [Shelf]
    */
    public function index() {
        //TODO: adjust render page
        return Inertia::render('BookKeeping/index',[
            'allBookKeepingHeaderBasedOnShelf' => Shelf::all()->load(
                'bookKeepingHeaders'
            )
        ]);
    }

    /*
        Variable 
        
        Request:
        fromFromDate: Date (nullable)
        fromToDate: Date (nullable)
        toFromDate: Date (nullable)
        toToDate: Date (nullable)

        Response:
        allBookKeepingHeaderBasedOnShelf: [BookKeepingHeader]
        
    */
    public function show(Shelf $shelf) {
        //TODO: adjust render page
        $request = request();
        $fromFromDate = $request['fromFromDate'] ?  DateHelper::createCarbonFromFormat(DateHelper::FRONT_END_FORMAT, $request['fromFromDate']) : null;
        $fromToDate = $request['fromToDate'] ?  DateHelper::createCarbonFromFormat(DateHelper::FRONT_END_FORMAT, $request['fromToDate']) : null;
        $toFromDate = $request['toFromDate'] ?  DateHelper::createCarbonFromFormat(DateHelper::FRONT_END_FORMAT, $request['toFromDate']) : null;
        $toToDate = $request['toToDate'] ?  DateHelper::createCarbonFromFormat(DateHelper::FRONT_END_FORMAT, $request['toToDate']) : null;

        return Inertia::render('BookKeeping/Show/index',[
            'allBookKeepingHeaderBasedOnShelf' =>  BookKeepingHeader::getBookKeepingHeaderByFilter(
                $shelf->id,
                $fromFromDate,
                $fromToDate,
                $toFromDate,
                $toToDate
            )
            ->orderBy('to_date', 'desc')
            ->paginate(25)
            ,
            'shelf' => $shelf
        ]);
    }

    /*
        Variable 
        
        Request:

        Response:
        allBookKeepingDetailBasedOnHeader: [BookKeepingDetail]
    */
    public function showBookKeepingDetail(BookKeepingHeader $bookKeepingHeader) {
        //TODO: adjust render page
        return Inertia::render('BookKeeping/ShowDetail/index',[
            'shelfName' => $bookKeepingHeader->shelf->name,
            'bookKeepingHeader' => $bookKeepingHeader,
            'allBookKeepingDetailBasedOnHeader' => CollectionHelper::paginate($bookKeepingHeader->bookKeepingDetails->load(
                'gold.shelf',
                'gold.goldCaratCategory',
                'gold.categories',
                'gold.user'
            ), 25)
        ]);
    }

    /*
        Variable 
        
        Request:

        Response:
        shelf: Shelf
        calculatedWeightStock : Float
        bookKeepingDetails: [BookKeepingDetail]
        fromDate: String
        toDate: String
        errorMessage: FlashMessage
        allStockInShelf: [Stock]
        totalPriceStock :Int
        totalQuantityStock: Int
        totalWeightStock: Int
    */
    public function create($shelfId) {
        if($shelfId == null) {
            return redirect()->route('bookkeeping.index')->with('errorMessage', 'Pembukuan tidak di temukan !!');
        }
        $response = BookKeepingDetail::getBookKeepingDetailsWithCalculatedWeightAndPrice($shelfId);
        //TODO: adjust render page
        if(sizeOf($response['bookKeepingDetails']) == 0) {
            return redirect()->route('bookkeeping.index')->with('errorMessage', 'Penambahan pembukuan belum bisa di gunakan karena belum terjadi transaksi apapun!!');
        }
            
        return Inertia::render('BookKeeping/Add/index',[
            'shelf' => Shelf::find($shelfId),
            'calculatedWeight' => $response['calculatedWeight'],
            'bookKeepingDetails' => $response['bookKeepingDetails']->load(
                'gold.shelf',
                'gold.goldCaratCategory',
                'gold.categories',
                'gold.user'
            ),
            'fromDate' => DateHelper::changeFormatToFormat(DateHelper::SYSTEM_FORMAT, DateHelper::USER_FORMAT, $response['fromDate']),
            'toDate' => $response['toDate']->format(DateHelper::USER_FORMAT),
            'allStockInShelf' => $response['allStockInShelf']->load(
                'gold.shelf',
                'gold.goldCaratCategory',
                'gold.categories',
                'gold.user'
            ),
            'totalPriceStock' => $response['totalPrice'],
            'totalQuantityStock' => $response['totalQuantity'],
            'totalWeightStock' => $response['totalWeight']
        ]);
    }

    /*
        Variable 
        
        Request:
        shelfId: String
        calculatedWeight: Float
        scaledWeight: Float
        bookKeepingDetailIds: [String]
        fromDate: String
        toDate: String

        Response:
        
    */
    public function store() {
        $request = request()->validate([
            'shelfId' => ['required'],
            'calculatedWeight' => ['required', 'numeric', 'gt:-1'],
            'scaledWeight' => ['required', 'numeric', 'gt:0'],
            'bookKeepingDetailIds' => ['required', 'array'],
            'fromDate' => ['required', 'date'],
            'toDate' => ['required', 'date'],

        ]);
        $shelf = Shelf::find($request['shelfId']);
        if ($shelf == null) {
            return redirect()->route('bookkeeping.index')->with('errorMessage', 'Rak tidak di temukan !!');
        }
        
        $bookKeepingHeader = new BookKeepingHeader();
        $bookKeepingHeader->shelf_id = $request['shelfId'];
        $bookKeepingHeader->calculation_weight = $request['calculatedWeight'];
        $bookKeepingHeader->scale_weight = $request['scaledWeight'];
        $bookKeepingHeader->from_date =  DateHelper::createCarbonFromFormat(DateHelper::USER_FORMAT, $request['fromDate']);
        $bookKeepingHeader->to_date = DateHelper::createCarbonFromFormat(DateHelper::USER_FORMAT,  $request['toDate']);

        $bookKeepingHeader->save();
        foreach ($request['bookKeepingDetailIds'] as $bookKeepingDetailId) {
            $bookKeepingDetail =  BookKeepingDetail::find($bookKeepingDetailId);
            $bookKeepingDetail->book_keeping_header_id = $bookKeepingHeader->id;
            $bookKeepingDetail->save();
        }

        

        //TODO: adjust render page
        return redirect()->route('bookkeeping.index')->with('successMessage', "Pembukuan di rak $shelf->name berhasil dimasukkan !!");
    }
}
