@extends('layouts.admin')

@section('title', 'Edit Materi - SahabatBuku')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="mb-8 text-3xl font-extrabold sm:text-3xl lg:text-4xl font-jakarta">
            Edit Materi
        </h1>

        @if ($errors->any())
            <div class="p-4 mb-6 border-l-4 border-red-500 bg-red-50">
                <ul class="text-red-700 list-disc list-inside font-jakarta">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
            <form action="{{ route('materi.update', ['materi' => $materi->id_materi, 'active_menu' => request()->input('active_menu')]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @vite('resources/js/admin/materi-editor.js')
                @csrf
                @method('PUT')

                {{-- Judul Materi Field --}}
                <div>
                    <label for="judul_materi" class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Judul Materi</label>
                    <input
                        type="text"
                        id="judul_materi"
                        name="judul_materi"
                        value="{{ old('judul_materi', $materi->judul_materi) }}"
                        required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl font-jakarta focus:outline-none focus:ring-2 focus:ring-[#F4922A] focus:border-transparent"
                    />
                </div>

                {{-- Isi Materi Field --}}
                <div>
                    @{{/* Editor Component */}}
                    <div x-data="materiEditor({{ json_encode(old('isi', $materi->isi) ?? '' }})" class="flex">
                        <!-- Main editor -->
                        <div class="flex-1 mr-4">
                            <input type="hidden" name="isi" x-ref="isi" />
                            <div x-ref="editor" class="border rounded-md p-2 min-h-[300px] focus:outline-none"></div>
                        </div>

                        <!-- Right side term panel -->
                        <div class="w-72 bg-gray-50 border-l p-4 overflow-y-auto" x-show="true">
                            <h2 class="mb-2 text-lg font-semibold">Tagged Terms</h2>
                            <template x-for="term in terms" :key="term.id">
                                <div class="flex items-center justify-between py-1 border-b border-gray-200">
                                    <div class="flex-1 cursor-pointer" @click="scrollToTerm(term)">
                                        <span class="font-medium" x-text="term.text"></span>
                                    </div>
                                    <div class="flex space-x-1">
                                        <button type="button" @click.stop="editTerm(term)" class="text-blue-600 hover:underline" title="Edit">Edit</button>
                                        <button type="button" @click.stop="deleteTerm(term)" class="text-red-600 hover:underline" title="Delete">Delete</button>
                                    </div>
                                </div>
                            </template>
                            <div class="mt-4">
                                <button type="button" @click="openTagModal" class="w-full py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Tag Term</button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for term definition -->
                    <div x-show="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-30" x-cloak>
                        <div class="bg-white rounded-lg shadow p-6 w-96">
                            <h3 class="mb-4 text-lg font-medium">Define Term</h3>
                            <p class="mb-2">Selected text: <span class="font-semibold" x-text="selectedText"></span></p>
                            <textarea x-model="definitionInput" rows="3" class="w-full border rounded p-2" placeholder="Enter definition"></textarea>
                            <div class="mt-4 flex justify-end space-x-2">
                                <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                                <button type="button" @click="confirmTag" class="px-4 py-2 bg-indigo-600 text-white rounded">Add</button>
                            </div>
                        </div>
                    </div>
                    <style>
                        .term { @apply border-b border-dashed border-indigo-500; }
                    </style>
                </div>

                {{-- Gambar Field --}}
                <div>
                    <label for="gambar" class="block mb-2 text-sm font-semibold text-slate-700 font-jakarta">Gambar (opsional)</label>
                    @if($materi->gambar)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2 font-jakarta">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $materi->gambar) }}" alt="Gambar Materi" class="max-w-xs h-auto rounded-lg border border-gray-200" />
                            <p class="text-xs text-gray-400 mt-2 font-jakarta">Upload gambar baru untuk menggantinya</p>
                        </div>
                    @endif
                    <input
                        type="file"
                        id="gambar"
                        name="gambar"
                        accept="image/*"
                        class="w-full text-base text-gray-500 cursor-pointer font-jakarta file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200"
                    />
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-4 pt-6">
                    <button type="submit" class="flex-1 py-3 text-lg font-bold text-white bg-admin-orange hover:bg-opacity-90 rounded-xl transition-all font-jakarta">
                        Simpan
                    </button>
                    <a href="{{ url()->previous() }}" class="flex-1 py-3 text-lg font-bold text-center text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all font-jakarta">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection