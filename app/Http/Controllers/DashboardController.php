<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\TransactionHeader;
use App\Models\PawnTransactionHeader;

class DashboardController extends Controller {
    const DAY = 'hari';
    const WEEK = 'minggu';
    const MONTH = 'bulan';
    
    public function index() 
    {
        $request = request();
        $profit = 0;
        $timestamp = $request['timestamp'] ? $request['timestamp'] : self::DAY;
        
        $transactionHeaders = self::getTransactionHeaderBasedOnTimestamp($timestamp, 10);
        $donePawnTransactionHeaders = self::getPawnTransactionHeaderBasedOnTimestampDeadlineDate($timestamp, true, 10);
        $undonePawnTransactionHeaders = self::getPawnTransactionHeaderBasedOnTimestampDeadlineDate($timestamp, false, 10);

        foreach ($transactionHeaders as $transactionHeader) {
            $profit += $transactionHeader->getTotalPriceGoldAttribute();
        }

        return Inertia::render('Dashboard',[
            'profit' => $profit,
            'undonePawn' => $undonePawnTransactionHeaders->load(
                'user',
                'customer',
                'pawnTransactionStatus',
            ),
            'donePawn' => $donePawnTransactionHeaders->load(
                'user',
                'customer',
                'pawnTransactionStatus',
            ),
            'allTransactionHistory' => $transactionHeaders->load(
                'user',
                'customer',
                'transactionDetails.gold.shelf', 
                'transactionDetails.gold.goldCaratCategory',
                'transactionDetails.gold.categories'
            )
        ]);
    }

    private function getTransactionHeaderBasedOnTimestamp($timestamp, $itemTakeCount)
    {
        switch ($timestamp) {
            case self::DAY:
                return TransactionHeader::getTransactionHeaderThisDay()->take($itemTakeCount)->orderBy('created_at', 'desc')->get();
                break;

            case self::WEEK:
                return TransactionHeader::getTransactionHeaderThisWeek()->take($itemTakeCount)->orderBy('created_at', 'desc')->get();
                break;

            case self::MONTH:
                return TransactionHeader::getTransactionHeaderThisMonth()->take($itemTakeCount)->orderBy('created_at', 'desc')->get();
                break;
            
            default:
                return TransactionHeader::all()->take($itemTakeCount);
                break;
        }
    }

    private function getPawnTransactionHeaderBasedOnTimestampDeadlineDate($timestamp, $isDone, $itemTakeCount)
    {
        switch ($timestamp) {
            case self::DAY:
                return PawnTransactionHeader::getPawnTransactionHeaderDeadlineDateThisDay($isDone)->orderBy('deadline_date','desc')->take($itemTakeCount)->get();
                break;
            case self::WEEK:
                return PawnTransactionHeader::getPawnTransactionHeaderDeadlineDateThisWeek($isDone)->orderBy('deadline_date','desc')->take($itemTakeCount)->get();
                break;

            case self::MONTH:
                return PawnTransactionHeader::getPawnTransactionHeaderDeadlineDateThisMonth($isDone)->orderBy('deadline_date','desc')->take($itemTakeCount)->get();
                break;
            
            default:
                return PawnTransactionHeader::getPawnTransactionHeaderBasedOnStatus($isDone)->take($itemTakeCount)->orderBy('deadline_date','desc')->get();
                break;
        }
    }
}