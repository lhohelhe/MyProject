<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="relative flex items-center justify-center w-full min-h-screen overflow-hidden bg-white">

        <div class="absolute left-0 top-30 -translate-x-1/3 -translate-y-[3%] w-[60vw] h-[100vh] max-w-[920px] max-h-[920px] rounded-full bg-[#405272] shadow-[0_0_10px_10px_rgba(0,0,0,0.25)]"></div>

        <div class="absolute left-[6%] top-1/2 -translate-y-1/2 
                    w-[25vw] min-w-[250px] max-w-[500px] z-8 hidden lg:block">
            <img
                src="{{ asset('images/Sign up-amico 1.png') }}"
                alt="Register Illustration"
                class="w-full h-auto drop-shadow-2xl"
            >
        </div>

        <!-- Card -->
        <div class="static z-6 w-full max-w-[500px] mx-2 lg:ml-auto lg:mr-[5%] bg-white rounded-[25px] shadow-[0_0_8px_5px_rgba(0,0,0,0.25)] px-6 sm:px-10 py-6">
            <h1 class="mb-6 text-3xl font-bold text-center text-black">
                Mendaftar
            </h1>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Nama -->
                <div>
                    <label class="block text-[20px] lg:text-[16px] text-black mb-3">Nama</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        class="w-full bg-transparent border-0 border-b border-black pb-2 text-[18px] lg:text-[20px] focus:outline-none focus:border-[#F0924E]">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-[20px] lg:text-[16px] text-black mb-3">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full bg-transparent border-0 border-b border-black pb-2 text-[18px] lg:text-[20px] focus:outline-none focus:border-[#F0924E]"
                    >
                </div>

                <!-- Kelas -->
                <div>
                    <label class="block text-[20px] lg:text-[16px] text-black mb-3">Kelas</label>
                    <select
                        name="kelas"
                        required
                        class="w-full bg-transparent border-0 border-b border-black pb-2 text-[18px] lg:text-[20px] focus:outline-none focus:border-[#F0924E]"
                    >
                        <option value="" disabled selected>Pilih Kelas</option>
                        <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>10</option>
                        <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>11</option>
                        <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>12</option>
                    </select>
                </div>
                

                <!-- Password -->
                <div>
                    <label class="block text-[20px] lg:text-[16px] text-black mb-3">Password</label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full bg-transparent border-0 border-b border-black pb-2 text-[18px] lg:text-[20px] focus:outline-none focus:border-[#F0924E]"
                    >
                </div>

                

                <!-- Confirm Password -->
                <div>
                    <label class="block text-[20px] lg:text-[16px] text-black mb-3">Konfirmasi Password</label>
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
                
                <!-- ke Login -->
                    <p class="mt-6 text-sm text-center">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-[#F0924E] font-semibold hover:underline">
                            Masuk di sini
                        </a>
                    </p>
            </form>
        </div>
    </div>
</body>
</html>
