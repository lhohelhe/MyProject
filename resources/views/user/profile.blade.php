<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap');
    .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>

<div class="flex min-h-screen font-jakarta" style="background-color: #E5F8FF;">

    <x-user-sidebar />

     {{-- ===== MAIN CONTENT ===== --}}
    <main class="flex-1 px-10 py-8">

        {{-- Motivation Card --}}
        <div class="flex items-center w-full gap-8 px-12 py-10 mb-8 rounded-2xl" style="background-color: #F4922A; min-height: 220px;">
            <button onclick="toggleEdit()" class="flex-shrink-0 transition-opacity hover:opacity-70" title="Klik untuk edit">
                <svg width="50" height="50" viewBox="0 0 50 50" fill="none">
                    <path d="M7.5 27.5C7.5 30.2578 9.74219 32.5 12.5 32.5H26.6797C28.0078 32.5 29.2812 31.9766 30.2188 31.0391L38.5391 22.7109C39.4766 21.7734 40 20.5 40 19.1719V5C40 2.24219 37.7578 0 35 0H12.5C9.74219 0 7.5 2.24219 7.5 5V27.5ZM22.5 8.75H25C25.6875 8.75 26.25 9.3125 26.25 10V13.75H30C30.6875 13.75 31.25 14.3125 31.25 15V17.5C31.25 18.1875 30.6875 18.75 30 18.75H26.25V22.5C26.25 23.1875 25.6875 23.75 25 23.75H22.5C21.8125 23.75 21.25 23.1875 21.25 22.5V18.75H17.5C16.8125 18.75 16.25 18.1875 16.25 17.5V15C16.25 14.3125 16.8125 13.75 17.5 13.75H21.25V10C21.25 9.3125 21.8125 8.75 22.5 8.75ZM3.75 9.375C3.75 8.33594 2.91406 7.5 1.875 7.5C0.835938 7.5 0 8.33594 0 9.375V35C0 37.7578 2.24219 40 5 40H25.625C26.6641 40 27.5 39.1641 27.5 38.125C27.5 37.0859 26.6641 36.25 25.625 36.25H5C4.3125 36.25 3.75 35.6875 3.75 35V9.375Z" fill="#3F3F3F"/>
                </svg>
            </button>
            <div class="flex-1">
                <p id="motivation-text" class="text-2xl italic font-normal text-center text-black">
                    "Beri catatan belajar kamu disini, agar tetap bersemangat menempuh pembelajaran"
                </p>
                <textarea id="motivation-input" class="hidden w-full p-3 text-lg text-black bg-white rounded resize-none focus:outline-none" rows="3" placeholder="Ketik motivasi kamu..."></textarea>
                <p id="edit-hint" class="hidden mt-2 text-xs text-center text-white">Tekan ESC untuk batal, klik icon untuk simpan</p>
            </div>
        </div>

        {{-- Dashboard --}}
        <h1 class="font-bold text-[28px] text-black mb-6">Dasbor</h1>
        <div class="text-lg text-gray-400">
            <p class="italic">Belum ada buku dengan progress. Mulai belajar!</p>
        </div>

    </main>

    {{-- ===== PROFILE PANEL ===== --}}
    <aside class="w-[380px] min-h-screen bg-white flex-shrink-0 flex flex-col items-center py-16 px-12" style="box-shadow: -4px 0 20px rgba(0,0,0,0.08);">

        <h2 class="font-medium text-[28px] text-black mb-8">Your Profile</h2>

        {{-- Avatar --}}
        <div class="relative mb-6">
            @if(auth()->user()->foto)
                <img src="{{ Storage::url(auth()->user()->foto) }}"
                     id="avatar-img"
                     class="w-40 h-40 rounded-full object-cover border-4 border-[#F8D4BD]">
            @else
                <svg id="avatar-svg" width="160" height="160" viewBox="0 0 200 200" fill="none">
                    <path d="M100 113.81C104.546 113.81 109.047 112.984 113.247 111.381C117.446 109.778 121.262 107.427 124.477 104.465C127.691 101.502 130.241 97.9851 131.98 94.1142C133.72 90.2433 134.615 86.0946 134.615 81.9048C134.615 77.715 133.72 73.5662 131.98 69.6953C130.241 65.8245 127.691 62.3073 124.477 59.3447C121.262 56.3821 117.446 54.032 113.247 52.4286C109.047 50.8252 104.546 50 100 50C95.4542 50 90.953 50.8252 86.7533 52.4286C82.5535 54.032 78.7376 56.3821 75.5232 59.3447C72.3089 62.3073 69.7591 65.8245 68.0196 69.6953C66.28 73.5662 65.3846 77.715 65.3846 81.9048C65.3846 86.0946 66.28 90.2433 68.0196 94.1142C69.7591 97.9851 72.3089 101.502 75.5232 104.465C78.7376 107.427 82.5535 109.778 86.7533 111.381C90.953 112.984 95.4542 113.81 100 113.81ZM91.4327 128.698C63.0192 128.698 40 149.915 40 176.104C40 180.464 43.8365 184 48.5673 184H151.433C156.163 184 160 180.464 160 176.104C160 149.915 136.981 128.698 108.567 128.698H91.4327Z" fill="black"/>
                    <path d="M200 100C200 155.228 155.228 200 100 200C44.7715 200 0 155.228 0 100C0 44.7715 44.7715 0 100 0C155.228 0 200 44.7715 200 100ZM14.708 100C14.708 147.105 52.8945 185.292 100 185.292C147.105 185.292 185.292 147.105 185.292 100C185.292 52.8945 147.105 14.708 100 14.708C52.8945 14.708 14.708 52.8945 14.708 100Z" fill="#F8D4BD"/>
                </svg>
            @endif

            {{-- Tombol upload foto (muncul saat edit mode) --}}
            <label id="foto-label" class="absolute bottom-0 right-0 hidden p-2 rounded-full cursor-pointer hover:opacity-80" style="background-color: #F4922A;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                    <circle cx="12" cy="13" r="4"/>
                </svg>
                <input type="file" id="input-foto" accept="image/*" class="hidden" onchange="previewFoto(this)">
            </label>
        </div>

        {{-- Name --}}
        <div class="flex items-center gap-2 mb-1">
            <span id="display-name" class="font-bold text-[22px] text-black underline">{{ auth()->user()->name }}</span>
            <button onclick="enableEdit('name')" class="hidden text-gray-400 hover:text-gray-600 edit-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </button>
            <input id="input-name" type="text" value="{{ auth()->user()->name }}" class="hidden border-b-2 border-orange-400 bg-transparent font-bold text-[22px] text-black focus:outline-none w-40">
        </div>

        {{-- Tagline --}}
        <div class="mb-8">
            <span class="text-[18px] text-black font-extralight">Tetap Semangat!</span>
        </div>

        {{-- Email --}}
        <div class="flex items-center w-full gap-4 mb-6">
            <svg width="28" height="21" viewBox="0 0 35 26" fill="none" class="flex-shrink-0">
                <path d="M3.25 0C1.45573 0 0 1.45573 0 3.25C0 4.2724 0.480729 5.23385 1.3 5.85L15.3833 16.4125C16.5411 17.2792 18.1255 17.2792 19.2833 16.4125L33.3667 5.85C34.1859 5.23385 34.6667 4.2724 34.6667 3.25C34.6667 1.45573 33.2109 0 31.4167 0H3.25ZM0 8.9375V21.6667C0 24.0568 1.94323 26 4.33333 26H30.3333C32.7234 26 34.6667 24.0568 34.6667 21.6667V8.9375L21.2333 19.0125C18.9245 20.7458 15.7422 20.7458 13.4333 19.0125L0 8.9375Z" fill="black"/>
            </svg>
            <span id="display-email" class="font-light text-[18px] text-black underline flex-1">{{ auth()->user()->email }}</span>
            <button onclick="enableEdit('email')" class="hidden text-gray-400 hover:text-gray-600 edit-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </button>
            <input id="input-email" type="email" value="{{ auth()->user()->email }}" class="hidden border-b-2 border-orange-400 bg-transparent font-light text-[18px] text-black focus:outline-none flex-1">
        </div>

        {{-- Kelas --}}
        <div class="flex items-center w-full gap-4 mb-10">
            <svg width="28" height="22" viewBox="0 0 36 28" fill="none" class="flex-shrink-0">
                <path d="M3 10.2375L16.075 15.6187C16.6875 15.8687 17.3375 16 18 16C18.6625 16 19.3125 15.8687 19.925 15.6187L35.075 9.38125C35.6375 9.15 36 8.60625 36 8C36 7.39375 35.6375 6.85 35.075 6.61875L19.925 0.38125C19.3125 0.13125 18.6625 0 18 0C17.3375 0 16.6875 0.13125 16.075 0.38125L0.925 6.61875C0.3625 6.85 0 7.39375 0 8V26.5C0 27.3312 0.66875 28 1.5 28C2.33125 28 3 27.3312 3 26.5V10.2375ZM6 14.7188V22C6 25.3125 11.375 28 18 28C24.625 28 30 25.3125 30 22V14.7125L21.0688 18.3937C20.0938 18.7937 19.0562 19 18 19C16.9438 19 15.9062 18.7937 14.9312 18.3937L6 14.7125V14.7188Z" fill="black"/>
            </svg>
            <span id="display-kelas" class="font-light text-[18px] text-black underline flex-1">Kelas {{ auth()->user()->kelas }}</span>
            <button onclick="enableEdit('kelas')" class="hidden text-gray-400 hover:text-gray-600 edit-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </button>
            <select id="input-kelas" class="hidden border-b-2 border-orange-400 bg-transparent font-light text-[18px] text-black focus:outline-none flex-1">
                <option value="10" {{ auth()->user()->kelas == '10' ? 'selected' : '' }}>Kelas 10</option>
                <option value="11" {{ auth()->user()->kelas == '11' ? 'selected' : '' }}>Kelas 11</option>
                <option value="12" {{ auth()->user()->kelas == '12' ? 'selected' : '' }}>Kelas 12</option>
            </select>
        </div>

        {{-- Simpan Button --}}
        <button id="btn-simpan" onclick="simpanProfile()" class="hidden rounded-lg px-8 py-3 font-extrabold text-[18px] text-white w-full mb-3" style="background-color: #F4922A;">
            Simpan
        </button>

        {{-- Edit Button --}}
        <button id="btn-edit" onclick="toggleEditMode()" class="rounded-lg px-8 py-3 font-extrabold text-[18px] text-white w-full" style="background-color: #F4922A;">
            Edit
        </button>

        {{-- Success message --}}
        <p id="success-msg" class="hidden"></p>

    </aside>

</div>

<script>
    // ===== MOTIVATION CARD =====
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

    // ===== PROFILE EDIT =====
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
                    const svg = document.getElementById('avatar-svg');
                    img = document.createElement('img');
                    img.id = 'avatar-img';
                    img.className = 'w-40 h-40 rounded-full object-cover border-4 border-[#F8D4BD]';
                    svg.replaceWith(img);
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