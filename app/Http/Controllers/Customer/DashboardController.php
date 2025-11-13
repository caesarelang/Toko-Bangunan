<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ringkasan status
        $summary = [
            'pending'     => $user->orders()->where('status', 'pending')->count(),
            'processing'  => $user->orders()->where('status', 'processing')->count(),
            'delivering'  => $user->orders()->where('status', 'delivering')->count(),
            'completed'   => $user->orders()->where('status', 'completed')->count(),
            'cancelled'   => $user->orders()->where('status', 'cancelled')->count(),
            'cancellation_requests' => $user->orders()->where('status', 'cancellation_requested')->count(),
        ];

        // Ambil 5 order terakhir
        $recentOrders = $user->orders()->latest()->take(5)->get();

        return view('Customer.dashboard', compact('summary', 'recentOrders'));
    }
    public function profile()
    {
        $user = auth()->user();
        return view('Customer.Profile.index', compact('user'));
    }
    public function editProfile()
    {
        $user = auth()->user();
        return view('Customer.Profile.edit', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'whatsapp' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $user->update($request->only('name', 'email', 'whatsapp', 'latitude', 'longitude'));

        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully.');
    }
}
