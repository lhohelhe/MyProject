@extends('layouts.admin')

@section('title', 'Detail Pengguna - SahabatBuku')

@section('content')
            <div class="w-full max-w-5xl mx-auto">
                <div class="bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl p-8 md:p-16 lg:p-20">

                    <h1 class="mb-12 text-3xl font-black text-black uppercase tracking-wider text-center md:text-4xl font-jakarta">
                        Detail Pengguna
                    </h1>

                    <div class="grid items-start grid-cols-1 gap-12 lg:grid-cols-3">
                        
                        <!-- KIRI: Foto Profil -->
                        <div class="flex flex-col items-center lg:col-span-1">
                            <label class="block mb-4 text-base font-bold text-black font-jakarta">Foto Profil</label>

                            @if($user->foto)
                                <img src="{{ asset('storage/' . $user->foto) }}" 
                                     class="object-cover w-40 h-40 border-2 border-black rounded-full">
                            @else
                                <div class="flex items-center justify-center w-40 h-40 text-3xl text-gray-400 bg-gray-200 border-2 border-black rounded-full">
                                    ?
                                </div>
                            @endif
                        </div>

                        <!-- KANAN: Data User -->
                        <div class="space-y-8 lg:col-span-2">

                            <div>
                                <label class="block mb-2 text-sm font-bold text-black font-jakarta">Nama Pengguna</label>
                                <p class="text-2xl font-black text-black font-jakarta">{{ $user->name }}</p>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-black font-jakarta">Email</label>
                                <p class="text-lg font-black text-black break-all font-jakarta">{{ $user->email }}</p>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-black font-jakarta">Kata Sandi</label>
                                <p class="text-lg font-black text-black font-jakarta">{{ $user->password }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-black font-jakarta">Kelas</label>
                                    <p class="text-lg font-black text-black font-jakarta">{{ $user->kelas ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-black font-jakarta">Role</label>
                                    <p class="inline-block px-4 py-2 text-lg font-bold text-white rounded-lg font-jakarta
                                        {{ $user->role === 'admin' ? 'bg-red-500' : 'bg-blue-500' }}">
                                        {{ $user->role }}
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-black font-jakarta">Terdaftar Sejak</label>
                                <p class="text-lg font-black text-black font-jakarta">{{ $user->created_at->format('d M Y H:i') }}</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-4 pt-8">
                                <a href="{{ route('dashboard-user.edit', $user->id) }}" 
                                   class="flex-1 py-4 text-xl font-bold text-center text-white bg-[#F4922A] border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all font-jakarta">
                                    Edit
                                </a>

                                <form action="{{ route('dashboard-user.destroy', $user->id) }}" method="POST" 
                                      class="flex-1"
                                      onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full py-4 text-xl font-bold text-white bg-red-500 border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all font-jakarta">
                                        Hapus
                                    </button>
                                </form>

                                <a href="{{ route('dashboard-user.index') }}" 
                                   class="flex-1 py-4 text-xl font-bold text-center text-black bg-white border-2 border-black shadow-[2px_2px_0px_#000] rounded-xl hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all font-jakarta">
                                    Kembali
                                </a>
                            </div>

                        </div>

                    </div>

                </div>
@endsection
