<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriMapel;
use App\Models\Bab;
use App\Models\Subab;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')
                    ->latest('id_buku') 
                    ->paginate(10);

        return view('admin.buku.dashboard-buku', compact('buku'));
    }

    public function create()
    {
        $kategori = KategoriMapel::all();
        return view('admin.buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_mapel,id_kategori',
            'semester' => 'required|string',
            'kelas' => 'required|string',
            'penulis' => 'nullable|string',
            'penerbit' => 'nullable|string',
            'isbn' => 'nullable|string',
            'edisi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['judul_buku', 'id_kategori', 'semester', 'kelas', 'deskripsi', 'penulis', 'penerbit', 'isbn', 'edisi']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('buku', 'public');
        }

        Buku::create($data);

        return redirect()->route('dashboard-buku.index')
                         ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = KategoriMapel::all();

        return view('admin.buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_mapel,id_kategori',
            'semester' => 'required|string',
            'kelas' => 'required|string',
            'penulis' => 'nullable|string',
            'penerbit' => 'nullable|string',
            'isbn' => 'nullable|string',
            'edisi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['judul_buku', 'id_kategori', 'semester', 'kelas', 'deskripsi']);

        if ($request->hasFile('gambar')) {// Hapus gambar lama kalau ada
            if ($buku->gambar) {
                Storage::disk('public')->delete($buku->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('buku', 'public');
        }

        $buku->update($data);

        return redirect()->route('dashboard-buku.index')
                         ->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->gambar) {
            Storage::disk('public')->delete($buku->gambar);
        }

        $buku->delete();

        return redirect()->route('dashboard-buku.index')
                         ->with('success', 'Buku berhasil dihapus!');
    }

    public function konten($id)
    {
        $buku = Buku::with(['bab.subab.materi'])->findOrFail($id);
        $babs = $buku->bab;
        return view('admin.buku.konten', compact('buku', 'babs'));
    }

    public function parsePdf(Request $request, $id)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:50000',
        ]);

        set_time_limit(120);

        try {

        $buku = Buku::findOrFail($id);
        $babIds = $buku->bab()->pluck('id_bab');
        $subbabIds = Subab::whereIn('id_bab', $babIds)->pluck('id_subbab');
	\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	\DB::table('materi')->whereIn('id_subbab', $subbabIds)->delete();
	\DB::table('subbab')->whereIn('id_bab', $babIds)->delete();
	\DB::table('bab')->where('id_buku', $buku->id_buku)->delete();
	\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($request->file('pdf')->path());
        $text = $pdf->getText();

        $lines = explode("\n", $text);

        $currentBab = null;
        $currentSubab = null;
        $currentMateriText = "";

        $createdData = [];
        $createdBabTitles = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            if (preg_match('/^BAB\s+([IVX\d]+)\s+(.+)$/i', $line, $matches)) {
                $nomorBab = $matches[1];
                $judulBab = trim($matches[2]);
                
                if (strlen($judulBab) >= 5) {
                    $cleanedJudul = preg_replace('/[\d\s]+$/', '', trim($judulBab));
                    if (in_array($cleanedJudul, $createdBabTitles)) {
                        continue;
                    }

                    if ($currentSubab && !empty(trim($currentMateriText))) {
                        Materi::create([
                            'id_subbab' => $currentSubab->id_subbab,
                            'judul_materi' => $currentSubab->judul_subbab,
                            'isi' => nl2br(trim($currentMateriText))
                        ]);
                        $currentMateriText = "";
                    }

                    $currentBab = Bab::create([
                        'id_buku' => $buku->id_buku,
                        'nomor_bab' => $nomorBab,
                        'judul_bab' => $judulBab
                    ]);

                    $createdBabTitles[] = $cleanedJudul;
                    $createdData[] = ['type' => 'bab', 'title' => $judulBab];
                    $currentSubab = null;
                    continue;
                }
            } 
            
            if (preg_match('/^([A-Z]\.)\s+(.+)$/', $line, $matches) && $currentBab) {
                $nomorSubbab = trim($matches[1], '.');
                $judulSubbab = trim($matches[2]);
                
                if (strlen($judulSubbab) >= 10) {
                    if ($currentSubab && !empty(trim($currentMateriText))) {
                        Materi::create([
                            'id_subbab' => $currentSubab->id_subbab,
                            'judul_materi' => $currentSubab->judul_subbab,
                            'isi' => nl2br(trim($currentMateriText))
                        ]);
                        $currentMateriText = "";
                    }

                    $currentSubab = Subab::create([
                        'id_bab' => $currentBab->id_bab,
                        'nomor_subbab' => $nomorSubbab,
                        'judul_subbab' => $judulSubbab
                    ]);

                    $createdData[] = ['type' => 'subbab', 'title' => $judulSubbab];
                    continue;
                }
            }
            
            if ($currentSubab) {
                $currentMateriText .= $line . "\n";
            }
        }

        if ($currentSubab && !empty(trim($currentMateriText))) {
            Materi::create([
                'id_subbab' => $currentSubab->id_subbab,
                'judul_materi' => $currentSubab->judul_subbab,
                'isi' => nl2br(trim($currentMateriText))
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'PDF berhasil diparse dan diekstrak',
            'data' => $createdData
        ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function parseAi(Request $request, $id)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:50000',
        ]);

        $apiKey = env('XAI_API_KEY');
        if (empty($apiKey)) {
            return response()->json(['error' => 'API Key Groq belum dikonfigurasi di .env.'], 500);
        }

        try {
            $buku = Buku::findOrFail($id);

            // Extract raw text using smalot/pdfparser
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($request->file('pdf')->path());
            $rawText = $pdf->getText();

            // Split raw text into chunks of maximum 6000 characters
            $chunks = str_split($rawText, 6000);
            $mergedBabs = [];

            foreach ($chunks as $chunkIndex => $chunk) {
                // Call Groq API for each chunk
                $response = \Illuminate\Support\Facades\Http::withoutVerifying()->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->timeout(120)->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.1-8b-instant',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => "Kamu adalah analis struktur buku pelajaran SMA Indonesia. Dari teks mentah hasil ekstraksi PDF, identifikasi struktur Bab dan Subbab. Abaikan nomor halaman, header, footer, daftar isi, glosarium, daftar pustaka. Untuk setiap Subbab, gabungkan semua paragraf isinya menjadi teks yang rapi dan mudah dibaca. Return JSON saja tanpa penjelasan apapun. Format wajib: {\"bab\":[{\"nomor\":\"1\",\"judul\":\"...\",\"subbab\":[{\"nomor\":\"A\",\"judul\":\"...\",\"isi\":\"...\"}]}]}"
                        ],
                        [
                            'role' => 'user',
                            'content' => $chunk
                        ]
                    ],
                    'response_format' => ['type' => 'json_object']
                ]);

                if (!$response->successful()) {
                    return response()->json(['error' => 'Gagal menghubungi API Groq pada bagian ke-' . ($chunkIndex + 1) . ': ' . $response->body()], 500);
                }

                $resultData = $response->json();
                $contentStr = $resultData['choices'][0]['message']['content'] ?? '{}';
                $parsedJson = json_decode($contentStr, true);

                if (isset($parsedJson['bab']) && is_array($parsedJson['bab'])) {
                    foreach ($parsedJson['bab'] as $b) {
                        $nomorBab = $b['nomor'] ?? '';
                        $judulBab = $b['judul'] ?? '';
                        $subbabs = $b['subbab'] ?? [];

                        // Check if Bab nomor already exists in merged list
                        $existingKey = null;
                        foreach ($mergedBabs as $key => $mb) {
                            if ($mb['nomor'] == $nomorBab) {
                                $existingKey = $key;
                                break;
                            }
                        }

                        if ($existingKey !== null) {
                            // Merge subbab arrays
                            $mergedBabs[$existingKey]['subbab'] = array_merge($mergedBabs[$existingKey]['subbab'], $subbabs);
                        } else {
                            $mergedBabs[] = [
                                'nomor' => $nomorBab,
                                'judul' => $judulBab,
                                'subbab' => $subbabs
                            ];
                        }
                    }
                }

                // Sleep between chunks to avoid rate limiting
                if ($chunkIndex < count($chunks) - 1) {
                    sleep(3);
                }
            }

            if (empty($mergedBabs)) {
                return response()->json(['error' => 'Gagal mengekstrak struktur buku dari seluruh bagian teks.'], 500);
            }

            // Save data
            $babIds = $buku->bab()->pluck('id_bab');
            $subbabIds = Subab::whereIn('id_bab', $babIds)->pluck('id_subbab');

            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            \DB::table('materi')->whereIn('id_subbab', $subbabIds)->delete();
            \DB::table('subbab')->whereIn('id_bab', $babIds)->delete();
            \DB::table('bab')->where('id_buku', $buku->id_buku)->delete();
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $createdData = [];

            foreach ($mergedBabs as $b) {
                $nomorBab = $b['nomor'] ?? '';
                $judulBab = $b['judul'] ?? '';

                $babModel = Bab::create([
                    'id_buku' => $buku->id_buku,
                    'nomor_bab' => $nomorBab,
                    'judul_bab' => $judulBab
                ]);

                $babData = [
                    'nomor' => $nomorBab,
                    'judul' => $judulBab,
                    'subbab' => []
                ];

                if (isset($b['subbab']) && is_array($b['subbab'])) {
                    foreach ($b['subbab'] as $s) {
                        $nomorSubbab = $s['nomor'] ?? '';
                        $judulSubbab = $s['judul'] ?? '';
                        $isiMateri = $s['isi'] ?? '';

                        $subModel = Subab::create([
                            'id_bab' => $babModel->id_bab,
                            'nomor_subbab' => $nomorSubbab,
                            'judul_subbab' => $judulSubbab
                        ]);

                        if (!empty($isiMateri)) {
                            Materi::create([
                                'id_subbab' => $subModel->id_subbab,
                                'judul_materi' => $judulSubbab,
                                'isi' => nl2br($isiMateri)
                            ]);
                        }

                        $babData['subbab'][] = [
                            'nomor' => $nomorSubbab,
                            'judul' => $judulSubbab,
                            'isi' => $isiMateri
                        ];
                    }
                }

                $createdData[] = $babData;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Struktur buku pelajaran berhasil diekstrak dan disimpan via AI',
                'data' => $createdData
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}