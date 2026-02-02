<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-h-screen w-full bg-white flex items-center justify-center overflow-hidden relative">

        <!-- Background circle -->
        <div class="absolute left-0 top-0 -translate-x-1/3 -translate-y-[3%] w-[60vw] h-[106vh] max-w-[1162px] max-h-[1147px] rounded-full bg-[#405272] shadow-[0_0_10px_10px_rgba(0,0,0,0.25)]"></div>

        <!-- Illustration -->
        <div class="absolute left-[2%] top-1/2 -translate-y-1/2 
                    w-[28vw] min-w-[280px] max-w-[520px] z-10 hidden lg:block">
            <img
                src="{{ asset('images/Sign up-amico 1.png') }}"
                alt="Register Illustration"
                class="w-full h-auto drop-shadow-2xl"
            >
        </div>

        <!-- Card -->
        <div class="relative z-20 w-full max-w-[623px] mx-4 lg:ml-auto lg:mr-[10%] bg-white rounded-[25px] shadow-[0_0_8px_5px_rgba(0,0,0,0.25)] px-8 sm:px-12 lg:px-16 py-10 lg:py-12">
            <h1 class="text-[clamp(32px,5vw,48px)] font-bold text-black mb-8 lg:mb-12 text-center">
                Mendaftar
            </h1>

            <form method="POST" action="{{ route('register') }}" class="space-y-8 lg:space-y-10">
                @csrf

                <!-- Nama -->
                <div>
                    <label class="block text-[20px] lg:text-[24px] text-black mb-3">Nama</label>
                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama') }}"
                        required
                        class="w-full bg-transparent border-0 border-b border-black pb-2 text-[18px] lg:text-[20px] focus:outline-none focus:border-[#F0924E]"
                    >
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-[20px] lg:text-[24px] text-black mb-3">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full bg-transparent border-0 border-b border-black pb-2 text-[18px] lg:text-[20px] focus:outline-none focus:border-[#F0924E]"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-[20px] lg:text-[24px] text-black mb-3">Password</label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full bg-transparent border-0 border-b border-black pb-2 text-[18px] lg:text-[20px] focus:outline-none focus:border-[#F0924E]"
                    >
                </div>

                <!-- Kelas -->
                <div>
                    <label class="block text-[20px] lg:text-[24px] text-black mb-3">Kelas</label>
                    <select
                        name="kelas"
                        required
                        class="w-full bg-transparent border-0 border-b border-black pb-2 text-[18px] lg:text-[20px] focus:outline-none focus:border-[#F0924E]"
                    >
                        <option value="" disabled selected>Pilih Kelas</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-[20px] lg:text-[24px] text-black mb-3">Konfirmasi Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full bg-transparent border-0 border-b border-black pb-2 text-[18px] lg:text-[20px] focus:outline-none focus:border-[#F0924E]"
                    >
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full bg-[#F0924E] text-white text-[20px] lg:text-[24px] font-bold rounded-[10px] py-3 lg:py-4 mt-8 hover:bg-[#e08440] transition"
                >
                    Lanjut
                </button>
            </form>
        </div>
    </div>
</body>
</html>
