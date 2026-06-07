@extends('layouts.user')

@section('content')
<div class="flex h-screen overflow-hidden bg-[#E5F8FF]">
    <x-user-sidebar />

    <div class="flex-1 flex flex-row font-jakarta h-screen overflow-hidden">
        <div class="flex-1 w-full mx-auto px-6 py-6 flex flex-col lg:flex-row gap-6 h-screen overflow-hidden">

            {{-- Left Sidebar: Chapter map --}}
            <aside class="w-full lg:w-[220px] shrink-0 h-[calc(100vh-3rem)] flex flex-col gap-3">

                {{-- Back button --}}
                <a href="{{ route('user.buku.show', $buku->id_buku) }}"
                   class="flex items-center gap-2 px-4 py-2.5 bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl text-xs font-black text-black hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    <span class="truncate">{{ $buku->judul_buku }}</span>
                </a>

                {{-- Chapter list --}}
                <div class="bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl p-4 flex flex-col flex-1 min-h-0">
                    <p class="text-[10px] font-black text-black uppercase tracking-widest mb-3 shrink-0">Daftar Subbab</p>
                    <div class="overflow-y-auto flex-1 pr-1 space-y-1">
                        <ul class="space-y-1">
                            @foreach($subbabList as $sub)
                                @php
                                    $isActive = ($sub->id_subbab == $materi->id_subbab);
                                    $firstMateri = $sub->materi->first();
                                    $materiLink = $firstMateri ? route('user.materi.baca', $firstMateri->id_materi) : '#';
                                @endphp
                                <li>
                                    <a href="{{ $materiLink }}"
                                       class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all text-xs font-bold
                                       {{ $isActive ? 'bg-[#F4922A] text-white border-2 border-black' : 'text-black hover:bg-slate-50 border-2 border-transparent' }}">
                                        <div class="w-2 h-2 rounded-full shrink-0 {{ $isActive ? 'bg-white' : 'bg-slate-300' }}"></div>
                                        <span class="truncate">{{ $sub->judul_subbab }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </aside>

            {{-- Center: Reading View --}}
            <main class="flex-1 max-w-[720px] mx-auto w-full h-screen overflow-y-auto pb-16">
                <article class="bg-white border-2 border-black shadow-[4px_4px_0px_#000] rounded-xl p-8">
                    <span class="inline-block bg-[#F4922A] text-white text-[10px] font-black px-3 py-1 border-2 border-black rounded-full shadow-[2px_2px_0px_#000] mb-4 uppercase tracking-wider">
                        Materi Belajar
                    </span>
                    <h1 class="text-2xl font-black text-black leading-tight mb-6 font-jakarta">
                        {{ $materi->judul_materi }}
                    </h1>

                    <div class="prose max-w-none text-slate-700 leading-relaxed font-serif text-base space-y-4">
                        {!! $materi->isi !!}
                    </div>

                    {{-- Navigation --}}
                    <div class="flex items-center justify-between mt-8 pt-6 border-t-2 border-black">
                        @if($prev)
                            <a href="{{ route('user.materi.baca', $prev->id_materi) }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-black bg-white border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i> Sebelumnya
                            </a>
                        @else
                            <div></div>
                        @endif

                        @if($next)
                            <a href="{{ route('user.materi.baca', $next->id_materi) }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[3px_3px_0px_#000] hover:shadow-none hover:translate-x-[3px] hover:translate-y-[3px] transition-all">
                                Lanjut <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </div>
                </article>
            </main>

            {{-- Right Sidebar: Progress & tools --}}
            <aside class="w-full lg:w-[220px] shrink-0 h-screen overflow-y-hidden sticky top-0 space-y-4">

                {{-- Progress card --}}
                <div class="bg-white border-2 border-black shadow-[3px_3px_0px_#000] rounded-xl p-4 space-y-4">
                    <div>
                        <p class="text-[10px] font-black text-black uppercase tracking-widest mb-2">Progress Bab</p>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-bold text-black">Selesai Dibaca</span>
                            <span class="text-xs font-black text-[#F4922A]">{{ $progress }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 border-2 border-black rounded-full h-3 overflow-hidden">
                            <div class="h-full rounded-full bg-[#F4922A] transition-all duration-500" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>

                    <div class="pt-3 border-t-2 border-black flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-black uppercase tracking-widest">XP Diperoleh</p>
                            <p class="text-lg font-black text-[#F4922A] mt-0.5">{{ $userXp }} XP</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-orange-50 border-2 border-black flex items-center justify-center text-[#F4922A]">
                            <i data-lucide="award" class="w-5 h-5"></i>
                        </div>
                    </div>

                    <div class="pt-3 border-t-2 border-black space-y-2">
                        <a href="{{ route('user.flashcard', $materi->subab->id_subbab) }}"
                           class="flex items-center justify-center gap-2 w-full py-2.5 text-xs font-bold text-black bg-white border-2 border-black rounded-xl shadow-[2px_2px_0px_#000] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                            <i data-lucide="book-marked" class="w-4 h-4"></i> Buka Flashcard
                        </a>
                        <a href="{{ route('user.quiz.index', $bab->id_bab) }}"
                           class="flex items-center justify-center gap-2 w-full py-2.5 text-xs font-bold text-white bg-[#F4922A] border-2 border-black rounded-xl shadow-[2px_2px_0px_#000] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                            <i data-lucide="clipboard-list" class="w-4 h-4"></i> Kerjakan Quiz
                        </a>
                    </div>
                </div>

            </aside>

        </div>
    </div>
</div>
@endsection
