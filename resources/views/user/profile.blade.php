<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap');
    .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
    .sidebar-glass {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
    }
</style>

<div class="flex min-h-screen font-jakarta" style="background-color: #E5F8FF;">

    <!--sidebar-->
    <aside class="sidebar-glass w-[280px] min-h-screen flex flex-col py-12 px-7 flex-shrink-0">

        <!--logo-->
        <img src="{{ asset('images/logo_1.png') }}" alt="SahabatBuku" class="h-10">

        <!--nav-->
        <nav class="flex flex-col flex-1 gap-16 mt-10">
            <a href="#" class="flex items-center gap-5 group">
                <svg width="22" height="23" viewBox="0 0 22 23" fill="none">
                    <path d="M2.89474 17.7727C2.127 17.7727 1.39072 18.0481 0.847849 18.5382C0.30498 19.0284 0 19.6932 0 20.3864M0 20.3864C0 21.0795 0.30498 21.7443 0.847849 22.2345C1.39072 22.7246 2.127 23 2.89474 23H22M0 20.3864V2.61364C0 1.92046 0.30498 1.25567 0.847849 0.765516C1.39072 0.275364 2.127 0 2.89474 0H20.8421L20.6667 17.78H2.88547M20.2632 17.7727C19.4954 17.7727 18.7591 18.0481 18.2163 18.5382C17.6734 19.0284 17.3684 19.6932 17.3684 20.3864C17.3684 21.0795 17.6734 21.7443 18.2163 22.2345C18.7591 22.7246 19.4954 23 20.2632 23" stroke="black" stroke-width="2"/>
                </svg>
                <span class="text-[26px] font-medium text-black">Katalog</span>
            </a>

            <!--kategori-->
            <div>
                <div class="flex items-center gap-5 mb-3">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <path d="M1.22222 9.77778H8.55556C8.87971 9.77778 9.19059 9.64901 9.4198 9.4198C9.64901 9.19059 9.77778 8.87971 9.77778 8.55556V1.22222C9.77778 0.898069 9.64901 0.587192 9.4198 0.357981C9.19059 0.128769 8.87971 0 8.55556 0H1.22222C0.898069 0 0.587192 0.128769 0.357981 0.357981C0.128769 0.587192 0 0.898069 0 1.22222V8.55556C0 8.87971 0.128769 9.19059 0.357981 9.4198C0.587192 9.64901 0.898069 9.77778 1.22222 9.77778ZM13.4444 9.77778H20.7778C21.1019 9.77778 21.4128 9.64901 21.642 9.4198C21.8712 9.19059 22 8.87971 22 8.55556V1.22222C22 0.898069 21.8712 0.587192 21.642 0.357981C21.4128 0.128769 21.1019 0 20.7778 0H13.4444C13.1203 0 12.8094 0.128769 12.5802 0.357981C12.351 0.587192 12.2222 0.898069 12.2222 1.22222V8.55556C12.2222 8.87971 12.351 9.19059 12.5802 9.4198C12.8094 9.64901 13.1203 9.77778 13.4444 9.77778ZM1.22222 22H8.55556C8.87971 22 9.19059 21.8712 9.4198 21.642C9.64901 21.4128 9.77778 21.1019 9.77778 20.7778V13.4444C9.77778 13.1203 9.64901 12.8094 9.4198 12.5802C9.19059 12.351 8.87971 12.2222 8.55556 12.2222H1.22222C0.898069 12.2222 0.587192 12.351 0.357981 12.5802C0.128769 12.8094 0 13.1203 0 13.4444V20.7778C0 21.1019 0.128769 21.4128 0.357981 21.642C0.587192 21.8712 0.898069 22 1.22222 22ZM17.1111 22C19.8073 22 22 19.8073 22 17.1111C22 14.4149 19.8073 12.2222 17.1111 12.2222C14.4149 12.2222 12.2222 14.4149 12.2222 17.1111C12.2222 19.8073 14.4149 22 17.1111 22Z" fill="black"/>
                    </svg>
                    <span class="text-[24px] font-medium text-black">Kategori</span>
                </div>
                <div class="flex gap-5 pl-1">
                    <div class="w-[3px] rounded-full bg-[#9E9E9E]"></div>
                    <div class="flex flex-col flex-1 gap-8">
                        <a href="#" class="text-[18px] font-medium text-black hover:text-blue-600">IPA</a>
                        <a href="#" class="text-[18px] font-medium text-black hover:text-blue-600">IPS</a>
                    </div>
                </div>
            </div>
        </nav>

        <!--tombol nav-->
        <div class="flex flex-col gap-8 mt-auto">
            <a href="{{ route('user.profile') }}" class="flex items-center gap-5">
                <svg width="22" height="27" viewBox="0 0 22 27" fill="none">
                    <path d="M11 12.8571C11.8334 12.8571 12.6586 12.6909 13.4286 12.3678C14.1985 12.0447 14.8981 11.5712 15.4874 10.9743C16.0767 10.3773 16.5442 9.66863 16.8631 8.88868C17.182 8.10873 17.3462 7.27278 17.3462 6.42857C17.3462 5.58436 17.182 4.74841 16.8631 3.96846C16.5442 3.18851 16.0767 2.47983 15.4874 1.88288C14.8981 1.28594 14.1985 0.812412 13.4286 0.489346C12.6586 0.16628 11.8334 0 11 0C10.1666 0 9.34138 0.16628 8.57143 0.489346C7.80148 0.812412 7.10189 1.28594 6.51259 1.88288C5.9233 2.47983 5.45584 3.18851 5.13692 3.96846C4.81799 4.74841 4.65385 5.58436 4.65385 6.42857C4.65385 7.27278 4.81799 8.10873 5.13692 8.88868C5.45584 9.66863 5.9233 10.3773 6.51259 10.9743C7.10189 11.5712 7.80148 12.0447 8.57143 12.3678C9.34138 12.6909 10.1666 12.8571 11 12.8571ZM9.42933 15.8571C4.22019 15.8571 0 20.1321 0 25.4089C0 26.2875 0.703365 27 1.57067 27H20.4293C21.2966 27 22 26.2875 22 25.4089C22 20.1321 17.7798 15.8571 12.5707 15.8571H9.42933Z" fill="black"/>
                </svg>
                <span class="text-[24px] font-medium text-black">Profil</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-5">
                    <svg width="22" height="30" viewBox="0 0 22 30" fill="none">
                        <path d="M10.1563 0C10.5453 0 10.9305 0.0754386 11.2899 0.222008C11.6493 0.368578 11.9758 0.583409 12.2509 0.854235C12.526 1.12506 12.7442 1.44658 12.8931 1.80043C13.0419 2.15428 13.1185 2.53354 13.1185 2.91654C13.1185 3.29955 13.0419 3.6788 12.8931 4.03265C12.7442 4.3865 12.526 4.70802 12.2509 4.97885C11.9758 5.24967 11.6493 5.4645 11.2899 5.61107C10.9305 5.75764 10.5453 5.83308 10.1563 5.83308C9.76728 5.83308 9.38208 5.75764 9.02268 5.61107C8.66329 5.4645 8.33673 5.24967 8.06166 4.97885C7.78659 4.70802 7.56839 4.3865 7.41952 4.03265C7.27066 3.6788 7.19404 3.29955 7.19404 2.91654C7.19404 2.53354 7.27066 2.15428 7.41952 1.80043C7.56839 1.44658 7.78659 1.12506 8.06166 0.854235C8.33673 0.583409 8.66329 0.368578 9.02268 0.222008C9.38208 0.0754386 9.76728 0 10.1563 0ZM6.77086 10.7079C6.77086 8.93711 8.23082 7.49968 10.0293 7.49968C11.1032 7.49968 12.1294 7.92153 12.8858 8.66629L15.4354 11.1766C15.7528 11.4891 16.1813 11.6662 16.6309 11.6662H18.6146C18.9214 11.6662 19.2123 11.7495 19.4609 11.8901V7.91632C19.4609 7.22365 20.0269 6.66638 20.7305 6.66638C21.434 6.66638 22 7.22365 22 7.91632V28.7488C22 29.4414 21.434 29.9987 20.7305 29.9987C20.0269 29.9987 19.4609 29.4414 19.4609 28.7488V14.7754C19.2123 14.916 18.9214 14.9994 18.6146 14.9994H16.6309C15.282 14.9994 13.9913 14.4733 13.0392 13.5359L12.6901 13.1921V18.8794L14.515 20.421C15.4513 21.2126 16.0649 22.3063 16.2395 23.5094L16.906 28.0977C17.0382 29.0092 16.3929 29.8529 15.4672 29.9831C14.5415 30.1133 13.6845 29.4779 13.5523 28.5665L12.8858 23.9781C12.8276 23.5771 12.6213 23.2125 12.3092 22.9469L8.53234 19.7596C7.40563 18.8117 6.76028 17.4211 6.76028 15.9629V10.7027L6.77086 10.7079Z" fill="#FF0000"/>
                    </svg>
                    <span class="text-[24px] font-medium text-[#FF0000]">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

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

        fetch('{{ route("profile.update.ajax") }}', {
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