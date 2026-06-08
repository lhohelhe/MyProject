<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap');
    .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>

<div class="flex min-h-screen font-jakarta bg-[#E5F8FF]">

    <x-user-sidebar />

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="flex-1 px-8 py-6">

        {{-- Motivation Card --}}
                <div class="flex items-center w-full gap-6 px-8 py-6 mb-8 border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl" style="background-color: #F4922A; min-height: 120px;">
                        <button onclick="toggleEdit()" class="flex-shrink-0 transition-opacity hover:opacity-70 text-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl" title="Klik untuk edit">
                <i data-lucide="notebook-pen" class="w-8 h-8"></i>
            </button>
            <div class="flex-1">
                <p id="motivation-text" class="text-lg italic font-medium text-center text-white">
                    "Beri catatan belajar kamu disini, agar tetap bersemangat menempuh pembelajaran"
                </p>
                <textarea id="motivation-input" class="hidden w-full p-2.5 text-base text-slate-800 bg-white rounded-xl resize-none focus:outline-none" rows="2" placeholder="Ketik motivasi kamu..."></textarea>
                <p id="edit-hint" class="hidden mt-1 text-[10px] text-center text-white/90">Tekan ESC untuk batal, klik icon untuk simpan</p>
            </div>
        </div>

        {{-- Dashboard --}}
        <h1 class="font-bold text-xl text-slate-800 mb-6 font-jakarta">Dasbor</h1>

        @if($bukuProgress->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-center bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="mb-4 text-slate-300">
                    <i data-lucide="library" class="w-12 h-12 mx-auto"></i>
                </div>
                <p class="italic text-slate-400 text-sm font-jakarta">Belum ada buku dengan progress. Mulai belajar!</p>
                <a href="{{ route('user.katalog') }}" class="px-5 py-2.5 mt-4 font-semibold text-white rounded-xl text-sm transition-colors hover:bg-orange-600 font-jakarta" style="background-color: #F4922A;">
                    Ke Katalog
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                @foreach($bukuProgress as $b)
                <a href="{{ route('user.buku.show', $b->id_buku) }}" class="flex flex-col bg-white rounded-2xl border-2 border-black shadow-[4px_4px_0px_#000] overflow-hidden hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] transition-all">
                    <div class="w-full overflow-hidden bg-slate-50" style="aspect-ratio: 3/4;">
                        @if($b->gambar)
                            <img src="{{ asset('storage/' . $b->gambar) }}" alt="{{ $b->judul_buku }}" class="object-cover w-full h-full">
                        @else
                            <div class="flex items-center justify-center w-full h-full">
                                <i data-lucide="book-open" class="w-10 h-10 text-slate-300"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-3">
                        <p class="mb-2 text-xs font-semibold text-slate-800 font-jakarta line-clamp-2">{{ $b->judul_buku }}</p>
                        <div class="w-full h-1.5 mb-1 bg-slate-100 rounded-full">
                            <div class="h-1.5 transition-all rounded-full" style="width: {{ $b->progress }}%; background-color: #F4922A;"></div>
                        </div>
                        <p class="text-[10px] text-slate-500 font-jakarta">{{ $b->progress }}% selesai</p>
                    </div>
                </a>
                @endforeach
            </div>
        @endif

    </main>

    {{-- ===== PROFILE PANEL ===== --}}
    <aside class="w-[320px] h-screen sticky top-0 bg-white flex-shrink-0 flex flex-col items-center py-10 px-8 overflow-y-auto border-l border-slate-100 shadow-sm">

        <h2 class="font-bold text-xl text-slate-800 mb-6">Your Profile</h2>

        {{-- Avatar --}}
        <div class="relative mb-6">
            @if(auth()->user()->foto)
                <img src="{{ asset('storage/' . auth()->user()->foto) }}"
                     id="avatar-img"
                     class="w-28 h-28 rounded-full object-cover border-4 border-orange-100">
            @else
                <div id="avatar-placeholder" class="w-28 h-28 rounded-full bg-orange-50 border-4 border-orange-100 flex items-center justify-center text-[#F4922A]">
                    <i data-lucide="user" class="w-12 h-12"></i>
                </div>
            @endif

            <label id="foto-label" class="absolute bottom-0 right-0 hidden p-1.5 rounded-full cursor-pointer hover:bg-orange-600 transition-colors shadow-sm bg-[#F4922A]">
                <i data-lucide="camera" class="w-4 h-4 text-white"></i>
                <input type="file" id="input-foto" accept="image/*" class="hidden" onchange="previewFoto(this)">
            </label>
        </div>

        {{-- Name --}}
        <div class="flex items-center gap-2 mb-1">
            <span id="display-name" class="font-bold text-lg text-slate-800">{{ auth()->user()->name }}</span>
            <button onclick="enableEdit('name')" class="hidden text-slate-400 hover:text-slate-600 edit-btn transition-colors">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
            </button>
            <input id="input-name" type="text" value="{{ auth()->user()->name }}" class="hidden bg-transparent font-bold text-lg text-slate-800 focus:outline-none w-32">
        </div>

        {{-- Tagline --}}
        <div class="mb-6">
            <span class="text-xs text-slate-400 font-medium">Tetap Semangat!</span>
        </div>

        {{-- Email --}}
        <div class="flex items-center w-full gap-3 mb-4 p-2 bg-slate-50 border-2 border-black rounded-xl shadow-[2px_2px_0px_#000]">
            <i data-lucide="mail" class="w-4 h-4 text-slate-400 flex-shrink-0"></i>
            <span id="display-email" class="text-xs text-slate-600 flex-1 truncate">{{ auth()->user()->email }}</span>
            <button onclick="enableEdit('email')" class="hidden text-slate-400 hover:text-slate-600 edit-btn transition-colors">
                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
            </button>
            <input id="input-email" type="email" value="{{ auth()->user()->email }}" class="hidden bg-transparent text-xs text-slate-600 focus:outline-none flex-1 w-24">
        </div>

        {{-- Kelas --}}
        <div class="flex items-center w-full gap-3 mb-8 p-2 bg-slate-50 border-2 border-black rounded-xl shadow-[2px_2px_0px_#000]">
            <i data-lucide="graduation-cap" class="w-4 h-4 text-slate-400 flex-shrink-0"></i>
            <span id="display-kelas" class="text-xs text-slate-600 flex-1">Kelas {{ auth()->user()->kelas }}</span>
            <button onclick="enableEdit('kelas')" class="hidden text-slate-400 hover:text-slate-600 edit-btn transition-colors">
                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
            </button>
            <select id="input-kelas" class="hidden bg-transparent text-xs text-slate-600 focus:outline-none flex-1">
                <option value="10" {{ auth()->user()->kelas == '10' ? 'selected' : '' }}>Kelas 10</option>
                <option value="11" {{ auth()->user()->kelas == '11' ? 'selected' : '' }}>Kelas 11</option>
                <option value="12" {{ auth()->user()->kelas == '12' ? 'selected' : '' }}>Kelas 12</option>
            </select>
        </div>

        {{-- Weekly Streak Tracker --}}
        <div class="w-full mb-6 p-4 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-1.5">
                    <i data-lucide="flame" class="w-4 h-4 text-[#F4922A]"></i>
                    <span class="text-xs font-black text-black uppercase tracking-wider">Streak Minggu Ini</span>
                </div>
                <span class="text-xs font-black text-[#F4922A]">{{ $totalStreak }} hari terpanjang</span>
            </div>

            {{-- 7 kotak hari --}}
            <div class="grid grid-cols-7 gap-1 mb-3">
                @foreach($weeklyStreak as $hari)
                <div class="flex flex-col items-center gap-1">
                    <div class="w-full aspect-square rounded-lg border-2 flex items-center justify-center
                        {{ $hari['aktif']
                            ? 'bg-[#F4922A] border-black shadow-[2px_2px_0px_#000]'
                            : ($hari['hari_ini']
                                ? 'bg-orange-50 border-[#F4922A] border-dashed'
                                : 'bg-slate-50 border-slate-200') }}">
                        @if($hari['aktif'])
                            <i data-lucide="flame" class="w-3 h-3 text-white"></i>
                        @elseif($hari['hari_ini'])
                            <div class="w-1.5 h-1.5 rounded-full bg-[#F4922A]"></div>
                        @else
                            <div class="w-1.5 h-1.5 rounded-full {{ $hari['lewat'] ? 'bg-slate-300' : 'bg-slate-200' }}"></div>
                        @endif
                    </div>
                    <span class="text-[9px] font-black {{ $hari['hari_ini'] ? 'text-[#F4922A]' : 'text-slate-400' }} uppercase">
                        {{ $hari['label'] }}
                    </span>
                </div>
                @endforeach
            </div>

            {{-- Status hari ini --}}
            @if($streakHariIni)
                <div class="flex items-center gap-2 px-3 py-2 bg-green-50 border-2 border-green-400 rounded-lg">
                    <i data-lucide="check-circle" class="w-3.5 h-3.5 text-green-600 flex-shrink-0"></i>
                    <p class="text-[10px] font-black text-green-700">Keren! Terus pertahankan progresmu</p>
                </div>
            @else
                <div class="flex items-center gap-2 px-3 py-2 bg-orange-50 border-2 border-[#F4922A] rounded-lg">
                    <i data-lucide="alarm-clock" class="w-3.5 h-3.5 text-[#F4922A] flex-shrink-0"></i>
                    <p class="text-[10px] font-black text-[#F4922A]">Belum belajar hari ini — jaga streakmu!</p>
                </div>
            @endif
        </div>

        {{-- Simpan Button --}}
                <button id="btn-simpan" onclick="simpanProfile()" class="hidden rounded-xl px-5 py-2 font-semibold text-sm text-white w-full mb-3 border-2 border-black shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all bg-[#F4922A]">
            Simpan
        </button>

        {{-- Edit Button --}}
                <button id="btn-edit" onclick="toggleEditMode()" class="rounded-xl px-5 py-2 font-semibold text-sm text-white w-full border-2 border-black shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all bg-[#F4922A]">
            Edit
        </button>

        <p id="success-msg" class="hidden mt-3 text-xs font-medium text-center text-green-600">
            <i data-lucide="check" class="w-3.5 h-3.5 inline-block mb-0.5"></i> Profil berhasil diperbarui!
        </p>

    </aside>

</div>

<script>
    const motivKey = 'motivationNote';
    const textEl = document.getElementById('motivation-text');
    const inputEl = document.getElementById('motivation-input');
    const hintEl = document.getElementById('edit-hint');
    let isEditing = false;

    const saved = localStorage.getItem(motivKey);
    if (saved) textEl.textContent = '"' + saved + '"';

    function toggleEdit() {
        isEditing = !isEditing;
        if (isEditing) {
            inputEl.value = textEl.textContent.replace(/^"|"$/g, '');
            textEl.classList.add('hidden');
            inputEl.classList.remove('hidden');
            hintEl.classList.remove('hidden');
            inputEl.focus();
        } else {
            const val = inputEl.value.trim();
            if (val) {
                textEl.textContent = '"' + val + '"';
                localStorage.setItem(motivKey, val);
            }
            textEl.classList.remove('hidden');
            inputEl.classList.add('hidden');
            hintEl.classList.add('hidden');
        }
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isEditing) {
            isEditing = false;
            textEl.classList.remove('hidden');
            inputEl.classList.add('hidden');
            hintEl.classList.add('hidden');
        }
    });

    let editMode = false;

    function toggleEditMode() {
        editMode = true;
        document.querySelectorAll('.edit-btn').forEach(btn => btn.classList.remove('hidden'));
        document.getElementById('foto-label').classList.remove('hidden');
        enableEdit('name');
        enableEdit('email');
        enableEdit('kelas');
        document.getElementById('btn-edit').classList.add('hidden');
        document.getElementById('btn-simpan').classList.remove('hidden');
        document.getElementById('success-msg').classList.add('hidden');
    }

    function enableEdit(field) {
        document.getElementById('display-' + field).classList.add('hidden');
        document.getElementById('input-' + field).classList.remove('hidden');
    }

    function previewFoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                let img = document.getElementById('avatar-img');
                if (!img) {
                    const placeholder = document.getElementById('avatar-placeholder');
                    img = document.createElement('img');
                    img.id = 'avatar-img';
                    img.className = 'w-28 h-28 rounded-full object-cover border-4 border-orange-100';
                    placeholder.replaceWith(img);
                }
                img.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function simpanProfile() {
        const formData = new FormData();
        formData.append('name', document.getElementById('input-name').value);
        formData.append('email', document.getElementById('input-email').value);
        formData.append('kelas', document.getElementById('input-kelas').value);

        const fotoInput = document.getElementById('input-foto');
        if (fotoInput.files[0]) {
            formData.append('foto', fotoInput.files[0]);
        }

        const btnSimpan = document.getElementById('btn-simpan');
        btnSimpan.textContent = 'Menyimpan...';

        fetch('{{ route("profile.update") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('display-name').textContent = formData.get('name');
                document.getElementById('display-email').textContent = formData.get('email');
                document.getElementById('display-kelas').textContent = 'Kelas ' + formData.get('kelas');

                ['name', 'email', 'kelas'].forEach(field => {
                    document.getElementById('display-' + field).classList.remove('hidden');
                    document.getElementById('input-' + field).classList.add('hidden');
                });

                document.querySelectorAll('.edit-btn').forEach(btn => btn.classList.add('hidden'));
                document.getElementById('foto-label').classList.add('hidden');
                document.getElementById('btn-edit').classList.remove('hidden');
                document.getElementById('btn-simpan').classList.add('hidden');
                btnSimpan.textContent = 'Simpan';
                document.getElementById('success-msg').classList.remove('hidden');
                editMode = false;

                if (typeof lucide !== 'undefined') lucide.createIcons();

                setTimeout(() => {
                    document.getElementById('success-msg').classList.add('hidden');
                }, 3000);
            }
        })
        .catch(() => {
            btnSimpan.textContent = 'Simpan';
            alert('Gagal menyimpan, coba lagi.');
        });
    }
</script>

</x-app-layout>