<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->where('role', 'user')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('admin.users', compact('users'));
    }

    // public function approveBendahara($id): RedirectResponse
    // {
    //     $user = User::where('id', $id)
    //         ->where('role', 'user')
    //         ->firstOrFail();

    //     $user->role = 'bendahara';
    //     $user->save();

    //     return redirect()
    //         ->route('admin.bendahara.pending')
    //         ->with('success', 'Permintaan bendahara telah disetujui.');
    // }

    // public function approve($id): RedirectResponse
    // {
    //     $user = User::where('id', $id)
    //         ->where('role', 'user')
    //         ->firstOrFail();

    //     $user->role = 'bendahara';
    //     $user->save();

    //     return redirect()
    //         ->route('admin.users')
    //         ->with('success', 'User telah disetujui menjadi bendahara.');
    // }
}
