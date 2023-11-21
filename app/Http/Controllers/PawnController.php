<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\PawnTransactionHeader;
use App\Models\PawnTransactionStatus;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Helpers\General\DateHelper;

class PawnController extends Controller
{
    const TODAY = 'TODAY';
    const TOMORROW = 'TOMORROW';
    const TWODAY = 'TWODAY';
    const WEEK = 'WEEK';

    /*
        Variable 
        
        Request:
        searchPawnKeyword: String (nullable)
        pawnStatusId: Int
        fromDate: Date (nullable)
        toDate: Date (nullable)

        Response:
        allPawnTransaction: [PawnTransactionHeader]
        defaultPawnStatusId: Int
    */
    
    public function index() {
        $request = request();
        $fromDate = $request['fromDate'] ?  DateHelper::createCarbonFromFormat(DateHelper::FRONT_END_FORMAT, $request['fromDate']) : null;
        $toDate = $request['toDate'] ?  DateHelper::createCarbonFromFormat(DateHelper::FRONT_END_FORMAT, $request['toDate']) : null;
        $defaultPawnStatusId = $request['pawnStatusId'] ? $request['pawnStatusId'] : null;

        $allPawnTransaction = PawnTransactionHeader::getPawnTransactionHeaderByFilter(
            $request['searchPawnKeyword'],
            $request['pawnStatusId'],
            $fromDate,
            $toDate
        )
        ->orderBy('deadline_date', 'desc')
        ->with(
            'pawnTransactionStatus',
            'user',
            'customer'
        )->paginate(25);
        
        return Inertia::render('Pawn/index',[
            'allPawnTransaction' => $allPawnTransaction,
            'defaultPawnStatusId' => $defaultPawnStatusId,
            'allPawnStatus' => PawnTransactionStatus::all()
        ]);
    }

    public function checkForUpcomingPawnAndPushNotif() {
        $oneWeek = PawnTransactionHeader::getUndonePawnTransactionHeaderBasedOnDeadlineDateUpcomingOneWeek()->get();
        $twoDays = PawnTransactionHeader::getUndonePawnTransactionheaderBasedOnDeadlineDateUpcomingTwoDays()->get();
        $tomorrow = PawnTransactionHeader::getUndonePawnTransactionheaderBasedOnDeadlineDateTomorrow()->get();
        $today = PawnTransactionHeader::getPawnTransactionHeaderDeadlineDateThisDay(false)->get();
    
        self::pushMultipleNotif($oneWeek, self::WEEK);
        self::pushMultipleNotif($twoDays, self::TWODAY);
        self::pushMultipleNotif($tomorrow, self::TOMORROW);
        self::pushMultipleNotif($today, self::TODAY);
    }

    public function show(PawnTransactionHeader $pawnTransactionHeader) {
        return Inertia::render('Pawn/Show/index',[
            'pawnTransactionHeader' => $pawnTransactionHeader->load(
                'pawnTransactionStatus',
                'user',
                'customer'
            )
        ]);
    }

    /*
        Variable 
        Request:
        Response:
    */
    public function create() {
        return Inertia::render('Pawn/Add/index');
    }

    /*
        Variable 
        Request:
        customerId: Int
        pawnPrice: Int
        deadlineDate: Int
        interestTotal: Int
        totalPrice: Int
        itemPrice: Int

        Response:

        Notes: 
        - calculated on front-end
    */
    public function store() {
        $request = request()->validate([
            'customerId' => ['required', 'numeric', 'gt:0'],
            'pawnPrice' => ['required', 'numeric', 'gt:0'],
            'interestTotal' => ['required', 'numeric', 'gt:0'],
            'totalPrice' => ['required', 'numeric', 'gt:0'],
            'itemPrice' => ['required', 'numeric', 'gt:0'],
            'deadlineDate' => ['required'],
        ]);
        
        $pawnTransactionHeader = PawnTransactionHeader::savePawnTransaction(
            $request['customerId'],
            $request['itemPrice'],
            $request['pawnPrice'],
            $request['interestTotal'],
            $request['totalPrice'],
            $request['deadlineDate']
        );

        return redirect()->route('pawn.show', $pawnTransactionHeader)->with([
            'successMessage' => "Transaksi gadai berhasil di buat dengan id:$pawnTransactionHeader->id ",
            'id' =>$pawnTransactionHeader->id
        ]);
    }

    /*
        Variable 
        Request:

        Response:
        pawnTransactionHeader: PawnTransactionHeader
    */
    public function edit(PawnTransactionHeader $pawnTransactionHeader) {
        //TODO: adjust render page
        return Inertia::render('Pawn/Edit/index',[
            'pawnTransactionHeader' => $pawnTransactionHeader->load(
                'pawnTransactionStatus',
                'user',
                'customer'
            ),
        ]);
    }

    /*
        Variable 
        Request:
        customerId: Int
        pawnPrice: Int
        deadlineDate: Date
        interestTotal: Int
        totalPrice: Int
        itemPrice: Int

        Response:

        Notes: 
        - calculated on front-end
    */
    public function update(PawnTransactionHeader $pawnTransactionHeader) {
        $request = request()->validate([
            'customerId' => ['required', 'numeric', 'gt:0'],
            'itemPrice' => ['required', 'numeric', 'gt:0'],
            'pawnPrice' => ['required', 'numeric', 'gt:0'],
            'interestTotal' => ['required', 'numeric', 'gt:0'],
            'totalPrice' => ['required', 'numeric', 'gt:0'],
            'deadlineDate' => ['required'],
        ]);

        $pawnTransactionHeader->user_id = Auth::id();
        $pawnTransactionHeader->customer_id = $request['customerId'];
        $pawnTransactionHeader->loan_price = $request['pawnPrice'];
        $pawnTransactionHeader->deadline_date = DateHelper::createCarbonFromFormat(DateHelper::FRONT_END_FORMAT, $request['deadlineDate']);
        $pawnTransactionHeader->interest_total = $request['interestTotal'];
        $pawnTransactionHeader->return_price = $request['totalPrice'];
        $pawnTransactionHeader->item_price = $request['itemPrice'];
        $pawnTransactionHeader->save();

        return redirect()->route('pawn.index')->with('successMessage', 'Transaksi gadai berhasil di ubah!!');
    }

    public function destory(PawnTransactionHeader $pawnTransactionHeader) {
        $pawnTransactionHeader->delete();
        return redirect()->route('pawn.index')->with('successMessage', 'Transaksi gadai berhasil di hapus!!');
    }

    /*
        Variable 
        Request:

        Response:
        customerName : String
        pawnTransactionStatus : String
        userName : String
        deadlineDate : Date
        loanPrice : Int
        returnPrice : Int
        totalInterest : Float
        created_at : Date
        dateDifferenceBetweenTodayAndDeadline : Int
        isLate : Boolean
        currentTempo : Int
        pawnTransactionHeaderId : Int
        firstTempo: Int

         Notes: 
        - calculated on back-end
    */
    public function showPawnTransactionHeaderAsDonePage(PawnTransactionHeader $pawnTransactionHeader) {
        if($pawnTransactionHeader->pawnTransactionStatus->status == 'done' ) {
            return redirect()->route('pawn.index')->with('errorMessage', 'Transaksi gadai sudah mempunyai status selesai!!');
        }
        $response = $pawnTransactionHeader->getUpdatedAttributeForResolveTransaction();
        //TODO: adjust render page
        return Inertia::render('Pawn/MarkAsDone/index', [
            'customerName' => $response['customerName'],
            'pawnTransactionStatus' => $response['pawnTransactionStatus'],
            'userName' => $response['userName'],
            'deadlineDate' => $response['deadlineDate'],
            'loanPrice' => $response['loanPrice'],
            'returnPrice' => $response['returnPrice'],
            'totalInterest' => $response['totalInterest'],
            'created_at' => $response['created_at'],
            'dateDifferenceBetweenTodayAndDeadline' => $response['dateDifferenceBetweenTodayAndDeadline'],
            'isLate' => $response['isLate'],
            'currentTempo' => $response['currentTempo'],
            'currentDate' => $response['currentDate'],
            'pawnTransactionHeaderId' => $pawnTransactionHeader->id,
            'firstTempo' => $response['firstTempo']
        ]);
    }

    /*
        Variable 
        Request:
        
        returnPrice : Int
        totalInterest : Float

        Response:
        errorMessage: FlashMessage
        successMessage: FlashMessage
        
        Notes: 
        - calculated on back-end
    */
    public function markPawnTransactionHeaderAsDone(PawnTransactionHeader $pawnTransactionHeader) {
        $request = request();
        if($pawnTransactionHeader->pawn_transaction_status_id == 1 ) {
            return redirect()->route('pawn.index')->with('errorMessage', 'Transaksi gadai sudah mempunyai status selesai!!');
        }
        if($request['returnPrice'] == null || $request['totalInterest'] == null){
            return redirect()->route('pawn.index')->with('errorMessage', 'Terjadi sesuatu silahkan coba beberapa saat lagi!!');
        }
        $pawnTransactionHeader->return_price = $request['returnPrice'];
        $pawnTransactionHeader->interest_total = $request['totalInterest'];
        $pawnTransactionHeader->deadline_date = Carbon::today();
        $pawnTransactionHeader->user_id = Auth::id();
        $pawnTransactionHeader->markAsDone();
        $pawnTransactionHeader->save();

        return redirect()->route('pawn.index')->with('successMessage', 'Gadai berhasil di selesaikan!!');

    }


    /*
        Variable 
        Request:

        Response:
        pawnTransactionHeader: PawnTransactionHeader
        errorMessage: FlashMessage
    */
    public function showPawnTransactionHeaderAsUnDonePage(PawnTransactionHeader $pawnTransactionHeader) {
        if($pawnTransactionHeader->pawn_transaction_status_id == 2 ) {
            return redirect()->route('pawn.index')->with('errorMessage', 'Transaksi gadai sudah mempunyai status selesai!!');
        }
        
        //TODO: adjust render page
        return Inertia::render('Pawn/MarkAsUnDone/index',
            ['pawnTransactionHeader' => $pawnTransactionHeader->load(
                'user',
                'customer',
                'pawnTransactionStatus'
                )]
        );
    }

    /*
        Variable 
        Request:
        deadlineDate: Date

        Response:
        successMessage: FlashMessage
        errorMessage: FlashMessage
    */
    public function markPawnTransactionHeaderAsUnDone(PawnTransactionHeader $pawnTransactionHeader) {
        $request = request()->validate([
            'deadlineDate' => ['required'],
        ]);
        
        // dd($request['deadlineDate']);
        if($pawnTransactionHeader->pawnTransactionStatus->status == 'undone' ) {
            return redirect()->route('pawn.index')->with('errorMessage', 'Transaksi gadai sudah mempunyai status belum selesai!!');
        }

        $pawnTransactionHeader->extendDeadlineDate($request['deadlineDate']);

        return redirect()->route('pawn.index')->with('successMessage', 'Batas pembayaran gadai berhasil di perpanjang!!!');
    }

    private function pushMultipleNotif($array, $timeStamp){
        foreach ($array as $data) {
            switch ($timeStamp) {
                case self::TODAY:
                    Notification::pushNotification("Gadai dengan id {$data->id} jatuh tempo hari ini, pada tanggal {$data->deadline_date}", "\pawn\\{$data->id}");
                break;

                case self::TOMORROW:
                    Notification::pushNotification("Gadai dengan id {$data->id} jatuh tempo besok, pada tanggal {$data->deadline_date}", "\pawn\\{$data->id}");
                break;

                case self::TWODAY:
                    Notification::pushNotification("Gadai dengan id {$data->id} jatuh tempo besok lusa, pada tanggal {$data->deadline_date}", "\pawn\\{$data->id}");
                break;

                case self::WEEK:
                    Notification::pushNotification("Gadai dengan id {$data->id} jatuh tempo minggu depan, pada tanggal {$data->deadline_date}", "\pawn\\{$data->id}");
                break;
            }
            
        }
    }
}
