<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
 public function index(Request $request)
    {
        $query = Transaction::with('user');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59',
            ]);
        } elseif ($request->filled('start_date')) {
            $query->where('created_at', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->filled('end_date')) {
            $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        $transactions = $query->latest()->paginate(20)->withQueryString();

        return view('Admin.Transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with('items.product', 'user')->findOrFail($id);
        return view('Admin.Transactions.show', compact('transaction'));
    }
}
