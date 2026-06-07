@extends('layouts.admin')

@section('title', 'Data Quiz - SahabatBuku')

@section('content')
        <h1 class="mb-6 text-3xl font-extrabold sm:text-3xl lg:text-4xl font-jakarta lg:mb-10 text-slate-800">
            Data Quiz
        </h1>
        
        <!-- Flash Message -->
        @if(session('success'))
        <div class="px-4 py-3 mb-6 text-green-800 bg-green-100 rounded-xl font-jakarta">
            {{ session('success') }}
        </div>
        @endif

        <!-- List Quiz -->
        <div class="overflow-hidden bg-white shadow-md rounded-2xl border border-slate-100 font-jakarta">
            <div class="p-6">
                <!-- Header Tabel Desktop -->
                <div class="hidden p-4 mb-4 rounded-lg bg-slate-50 lg:block border border-slate-100">
                    <div class="grid grid-cols-12 gap-4 text-base font-semibold text-center text-slate-600">
                        <div class="col-span-1">No</div>
                        <div class="col-span-5 text-left">Judul Quiz</div>
                        <div class="col-span-6 text-left">Bab</div>
                    </div>
                </div>

                <!-- List Item -->
                @forelse($quiz as $index => $q)
                <div class="p-4 mb-4 border border-slate-100 rounded-xl bg-white hover:shadow-sm transition-shadow">
                    <!-- Desktop View -->
                    <div class="items-center hidden grid-cols-12 gap-4 text-center lg:grid text-slate-700">
                        <div class="col-span-1 font-semibold text-slate-800">{{ $quiz->firstItem() + $index }}</div>
                        <div class="col-span-5 font-bold text-left text-slate-800">{{ $q->judul_quiz }}</div>
                        <div class="col-span-6 font-medium text-left text-sm text-slate-500">
                            {{ $q->bab->buku->judul_buku ?? '-' }} &middot; Bab {{ $q->bab->nomor_bab ?? '-' }}: {{ $q->bab->judul_bab ?? '-' }}
                        </div>
                    </div>

                    <!-- Mobile View -->
                    <div class="space-y-2 lg:hidden">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-gray-500">No:</span>
                            <span class="font-semibold text-slate-800">{{ $quiz->firstItem() + $index }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-gray-500">Judul Quiz:</span>
                            <span class="font-bold text-slate-800">{{ $q->judul_quiz }}</span>
                        </div>
                        <div class="flex items-start justify-between">
                            <span class="font-medium text-gray-500">Bab:</span>
                            <span class="text-slate-500 text-sm text-right">
                                {{ $q->bab->buku->judul_buku ?? '-' }} &middot; Bab {{ $q->bab->nomor_bab ?? '-' }}: {{ $q->bab->judul_bab ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center bg-white rounded-2xl">
                    <p class="text-lg text-gray-500">Belum ada quiz terdaftar</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if($quiz->hasPages())
        <div class="mt-8">
            {{ $quiz->links() }}
        </div>
        @endif
@endsection
