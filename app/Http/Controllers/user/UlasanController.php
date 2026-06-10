<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UlasanController extends Controller
{
    public function index()
    {
        $ulasans = Ulasan::with('user')
            ->where('published', true)
            ->latest()
            ->paginate(6);

        // Calculate average rating and total reviews
        $averageRating = Ulasan::where('published', true)->avg('rating') ?? 0;
        $totalReviews = Ulasan::where('published', true)->count();

        return view('pageuser.ulasan.index', compact('ulasans', 'averageRating', 'totalReviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'required|string|min:5|max:1000',
        ], [
            'rating.required' => 'Peringkat bintang wajib diisi.',
            'ulasan.required' => 'Pesan ulasan wajib diisi.',
            'ulasan.min' => 'Pesan ulasan minimal 5 karakter.',
            'ulasan.max' => 'Pesan ulasan maksimal 1000 karakter.',
        ]);

        Ulasan::create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'ulasan' => $request->ulasan,
            'published' => true, // Default to true, admin can unpublish/delete
        ]);

        Alert::success('Berhasil', 'Terima kasih atas ulasan Anda!');
        return redirect()->route('user.ulasan');
    }
}
