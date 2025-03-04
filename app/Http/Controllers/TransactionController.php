<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
                        ->with(['shipment', 'items.product'])
                        ->latest()
                        ->get();

        return view('frontend.transaction', compact('transactions'));
    }
}
