@extends('layouts.admin')

@section('title', 'Data Buku - SahabatBuku')

@section('content')
<h1 class="mb-6 text-2xl font-black text-black uppercase tracking-wider font-jakarta">
    Data Buku
</h1>

{{-- Banner panduan: muncul saat masuk dari menu Kelola Bab & Subbab --}}
<div id="bab-guide-banner" class="hidden mb-6 flex items-start gap-3 p-4 bg-[#1E3A5F] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl">
    <i data-lucide="info" class="w-5 h-5 text-[#F4922A] flex-shrink-0 mt-0.5"></i>
    <div>
        <p class="text-sm font-black text-white">Untuk kelola Bab, Subbab, dan Materi:</p>
        <p class="text-xs font-bold text-blue-200 mt-0.5">Pilih buku di bawah → klik tombol <span class="text-[#F4922A]">Konten</span> → kelola struktur buku secara langsung.</p>
    </div>
    <button onclick="document.getElementById('bab-guide-banner').classList.add('hidden')" class="ml-auto text-white/50 hover:text-white flex-shrink-0">
        <i data-lucide="x" class="w-4 h-4"></i>
    </button>
</div>

{{-- Header bar --}}
<div class="flex items-center justify-between p-4 mb-6 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl">
    <p class="text-sm font-black text-black font-jakarta uppercase tracking-wider">
        Total: <span id="total-buku" class="text-[#F4922A]">0</span> buku
    </p>
    <a href="{{ route('dashboard-buku.create') }}"
       class="flex items-center gap-2 px-4 py-2.5 text-sm font-black text-white bg-[#F4922A] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all font-jakarta">
        + Tambah Buku
    </a>
</div>

{{-- List --}}
<div id="list-buku" class="space-y-3"></div>

<script>
async function loadBuku() {
    try {
        const response = await fetch('http://127.0.0.1:8000/api/buku');
        const result   = await response.json();
        const data     = result.data?.data || result.data || result;

        document.getElementById('total-buku').innerText = data.length;

        if (data.length === 0) {
            document.getElementById('list-buku').innerHTML = `
                <div class="p-8 text-center bg-white border-2 border-black rounded-xl">
                    <p class="font-bold text-slate-400">Belum ada data buku terdaftar</p>
                </div>`;
            return;
        }

        const activeMenu = new URLSearchParams(window.location.search).get('active_menu') || 'bab';

        let html = '';
        data.forEach(b => {
            const cover = b.gambar
                ? `<img src="{{ asset('storage') }}/${b.gambar}" class="w-16 h-22 object-cover rounded-lg border-2 border-black flex-shrink-0" style="height:88px;min-width:56px;">`
                : `<div class="flex items-center justify-center rounded-lg border-2 border-black bg-slate-100 flex-shrink-0 text-slate-400" style="height:88px;min-width:56px;">📖</div>`;

            const truncate = (str, n) => str && str.length > n ? str.slice(0, n) + '…' : (str || '-');

            html += `
            <div class="bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl overflow-hidden font-jakarta">
                <div class="flex items-start gap-4 p-4">

                    {{-- Cover --}}
                    ${cover}

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="font-black text-black text-sm leading-snug truncate mb-1">${b.judul_buku}</p>
                        <div class="flex items-center gap-2 flex-wrap mb-2">
                            <span class="px-2 py-0.5 text-[10px] font-black text-white bg-[#F4922A] border border-black rounded-full">${b.kategori?.nama_kategori ?? '-'}</span>
                            <span class="px-2 py-0.5 text-[10px] font-black text-black bg-slate-100 border border-slate-300 rounded-full">Kelas ${b.kelas}</span>
                            <span class="px-2 py-0.5 text-[10px] font-black text-black bg-slate-100 border border-slate-300 rounded-full">Sem. ${b.semester}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-xs text-slate-600 font-bold">
                            <div class="truncate"><span class="text-slate-400 font-black uppercase tracking-wider text-[10px]">Penulis</span><br>${truncate(b.penulis, 22)}</div>
                            <div class="truncate"><span class="text-slate-400 font-black uppercase tracking-wider text-[10px]">Penerbit</span><br>${truncate(b.penerbit, 22)}</div>
                            <div class="truncate"><span class="text-slate-400 font-black uppercase tracking-wider text-[10px]">ISBN</span><br>${truncate(b.isbn, 20)}</div>
                            <div class="truncate"><span class="text-slate-400 font-black uppercase tracking-wider text-[10px]">Edisi</span><br>${truncate(b.edisi, 12)}</div>
                        </div>
                    </div>

                    {{-- Aksi --}}
                    <div class="flex flex-col gap-1.5 flex-shrink-0">
                        <a href="/admin/buku/${b.id_buku}/konten"
                           class="flex items-center gap-1.5 px-2.5 py-1.5 text-[10px] font-black text-white bg-[#1E3A5F] border-2 border-black shadow-[2px_2px_0px_#000] rounded-lg hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all"
                           title="Kelola Konten">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                            Konten
                        </a>
                        <a href="/admin/bab?id_buku=${b.id_buku}&active_menu=${activeMenu}"
                           class="flex items-center gap-1.5 px-2.5 py-1.5 text-[10px] font-black text-black bg-white border-2 border-black shadow-[2px_2px_0px_#000] rounded-lg hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all"
                           title="Kelola Bab">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-10 5 10 5 10-5-10-5Z"/><path d="m2 17 10 5 10-5"/><path d="m2 12 10 5 10-5"/></svg>
                            Bab
                        </a>
                        <a href="/admin/dashboard-buku/${b.id_buku}/edit"
                           class="flex items-center gap-1.5 px-2.5 py-1.5 text-[10px] font-black text-[#F4922A] bg-white border-2 border-black shadow-[2px_2px_0px_#000] rounded-lg hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all"
                           title="Edit Buku">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                            Edit
                        </a>
                        <button onclick="deleteBuku(${b.id_buku})"
                                class="flex items-center gap-1.5 px-2.5 py-1.5 text-[10px] font-black text-white bg-red-500 border-2 border-black shadow-[2px_2px_0px_#000] rounded-lg hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all"
                                title="Hapus Buku">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>`;
        });

        document.getElementById('list-buku').innerHTML = html;

    } catch (error) {
        console.error('Error:', error);
    }
}

async function deleteBuku(id) {
    if (!confirm('Yakin ingin menghapus buku ini?')) return;
    await fetch(`http://127.0.0.1:8000/api/buku/${id}`, { method: 'DELETE' });
    loadBuku();
}

loadBuku();

// Tampilkan banner panduan jika masuk dari menu "Kelola Bab & Subbab"
if (sessionStorage.getItem('goto') === 'bab') {
    document.getElementById('bab-guide-banner').classList.remove('hidden');
    sessionStorage.removeItem('goto');
    setTimeout(() => {
        document.getElementById('list-buku').scrollIntoView({ behavior: 'smooth' });
    }, 800);
}

if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
@endsection
