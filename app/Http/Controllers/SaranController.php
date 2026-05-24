<?php
namespace App\Http\Controllers;

use App\Models\Saran;
use Illuminate\Http\Request;

class SaranController extends Controller
{
    // Store saran from landing page footer form
    public function store(Request $request)
    {
        $request->validate(['isi' => 'required|string|max:1000']);
        Saran::create(['isi' => $request->isi]);
        return back()->with('saran_success', 'Terima kasih! Saran kamu sudah kami terima. 🙏');
    }

    // Admin index - list only unread saran
    public function index()
    {
        $sarans = Saran::where('status', 'belum_dibaca')->latest()->paginate(15);
        return view('admin.saran.index', compact('sarans'));
    }

    // Admin mark as read
    public function markRead($id)
    {
        $saran = Saran::findOrFail($id);
        $saran->update(['status' => 'sudah_dibaca']);
        return back()->with('success', 'Saran ditandai sudah dibaca.');
    }

    // Admin delete
    public function destroy($id)
    {
        Saran::findOrFail($id)->delete();
        return back()->with('success', 'Saran berhasil dihapus.');
    }
}
