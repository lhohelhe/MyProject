@extends('layouts.user')

@section('content')
<div class="flex h-screen overflow-hidden bg-[#E5F8FF]">
    {{-- Sidebar Navigation --}}
    <x-user-sidebar />

    {{-- Main Container --}}
    <div class="flex-1 flex flex-row font-jakarta h-screen overflow-hidden">
        {{-- Reading View Content wrapper --}}
        <div class="flex-1 w-full mx-auto px-6 py-8 flex flex-col lg:flex-row gap-8 h-screen overflow-hidden">
            
            {{-- Left Sidebar: Chapter map --}}
            <aside class="w-full lg:w-[240px] shrink-0 h-[calc(100vh-4rem)] flex flex-col">
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-col max-h-full">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 shrink-0">Daftar Subbab</p>
                    <div class="overflow-y-auto flex-1 pr-1 space-y-1 scrollbar-thin">
                        <ul class="space-y-1">
                            @foreach($subbabList as $sub)
                                @php
                                    $isActive = ($sub->id_subbab == $materi->id_subbab);
                                    $firstMateri = $sub->materi->first();
                                    $materiLink = $firstMateri ? route('user.materi.baca', $firstMateri->id_materi) : '#';
                                @endphp
                                <li>
                                    <a href="{{ $materiLink }}" 
                                       class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all text-xs font-medium 
                                       {{ $isActive ? 'bg-[#E5F8FF] text-[#F4922A] font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                                        <div class="w-2 h-2 rounded-full shrink-0 {{ $isActive ? 'bg-[#F4922A]' : 'bg-slate-300' }}"></div>
                                        <span class="truncate">{{ $sub->judul_subbab }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </aside>

            {{-- Center Column: Reading View --}}
            <main class="flex-1 max-w-[720px] mx-auto w-full h-screen overflow-y-auto pb-24">
                <article class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100/80">
                    <span class="inline-block bg-[#F4922A]/10 text-[#F4922A] text-[10px] font-bold px-3 py-1 rounded-lg mb-4 uppercase tracking-wider">
                        Materi Belajar
                    </span>
                    <h1 class="text-3xl font-extrabold text-slate-900 leading-tight mb-6 font-jakarta">
                        {{ $materi->judul_materi }}
                    </h1>
                    
                    <div class="prose max-w-none text-slate-700 leading-relaxed font-serif text-lg space-y-5">
                        {!! $materi->isi !!}
                    </div>

                    {{-- Navigation buttons --}}
                    <div class="flex items-center justify-between mt-10 pt-6 border-t border-slate-100">
                        @if($prev)
                            <a href="{{ route('user.materi.baca', $prev->id_materi) }}" 
                               class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-[#F4922A] hover:bg-[#E5F8FF] rounded-xl transition-all">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i> Sebelum
                            </a>
                        @else
                            <div></div>
                        @endif

                        @if($next)
                            <a href="{{ route('user.materi.baca', $next->id_materi) }}" 
                               class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-white bg-[#F4922A] hover:bg-opacity-95 rounded-xl transition-all shadow-md shadow-orange-200">
                                Lanjut <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </div>
                </article>
            </main>

            {{-- Right Sidebar: Reading progress --}}
            <aside class="w-full lg:w-[240px] shrink-0 space-y-4 h-screen overflow-y-hidden sticky top-0">
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm space-y-5">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Progress Bab</p>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-semibold text-slate-500">Selesai Dibaca</span>
                            <span class="text-xs font-bold text-[#F4922A]">{{ $progress }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5">
                            <div class="h-1.5 rounded-full bg-[#F4922A] transition-all duration-500" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">XP Diperoleh</p>
                            <p class="text-lg font-extrabold text-[#F4922A] mt-0.5">{{ $userXp }} XP</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-[#F4922A]">
                            <i data-lucide="award" class="w-5 h-5"></i>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 space-y-2">
                        <a href="{{ route('user.flashcard', $materi->subab->id_subbab) }}" 
                           class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 transition-all border border-slate-200/50">
                            <i data-lucide="book-marked" class="w-4 h-4 text-slate-400"></i> Buka Flashcard
                        </a>
                        <a href="{{ route('user.quiz.index', $bab->id_bab) }}" 
                           class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-xs font-bold text-[#1E3A5F] bg-blue-50 hover:bg-blue-100 transition-all border border-blue-200/30">
                            <i data-lucide="clipboard-list" class="w-4 h-4 text-[#1E3A5F]/80"></i> Kerjakan Quiz
                        </a>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</div>
@endsection
