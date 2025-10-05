<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function index()
    {
        $data = [
            'reviews' => Review::paginate(10),
            'menu' => 'Daftar Review',
            'submenu' => 'Daftar Review',
        ];

        return view('backend.reviews.index', $data);
    }

    public function destroy(Review $review)
    {
        DB::transaction(function () use ($review) {
            $review->delete();
        });

        return redirect()->route('review.index')->with('destroy', 'Review berhasil dihapus.');
    }
}
