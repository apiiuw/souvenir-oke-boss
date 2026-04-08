@extends('layouts.admin')

@section('admin_container')
<div class="space-y-8">
    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manajemen Kategori</h2>
            <p class="text-sm text-gray-500">Kelola kategori produk untuk mempermudah pencarian pelanggan.</p>
        </div>
        <button onclick="openModal('modal-add')" class="flex items-center justify-center gap-2 px-6 py-3 bg-pink-oke-boss text-white font-bold rounded-2xl hover:bg-pink-600 transition-all shadow-lg shadow-pink-100 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kategori
        </button>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-xl animate-fade-in-up">
        <div class="flex items-center">
            <div class="shrink-0 text-green-400">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-xl animate-fade-in-up">
        <div class="flex items-center">
            <div class="shrink-0 text-red-400">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-bold text-red-800">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Content Table -->
    <div class="bg-white rounded-4xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                        <th class="px-8 py-5">Nama Kategori</th>
                        <th class="px-8 py-5">Slug (URL)</th>
                        <th class="px-8 py-5 text-center">Jumlah Produk</th>
                        <th class="px-8 py-5 text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($categories as $category)
                    <tr class="group hover:bg-gray-50/50 transition-all">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-pink-50 rounded-xl flex items-center justify-center text-pink-500 font-bold group-hover:scale-110 transition-transform">
                                    {{ substr($category->name, 0, 1) }}
                                </div>
                                <span class="font-bold text-gray-900">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-gray-100 text-gray-500 text-xs rounded-full font-medium">{{ $category->slug }}</span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-50 text-blue-600 rounded-full text-xs font-bold">
                                {{ $category->products_count }} <span class="font-medium opacity-70">Produk</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button 
                                    onclick="editCategory({{ $category->id }}, '{{ $category->name }}')"
                                    class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-all" title="Ubah">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button 
                                    onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}')"
                                    class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <p class="text-gray-500 font-medium">Belum ada kategori tersedia.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div id="modal-add" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-60 flex items-center justify-center hidden opacity-0 transition-all duration-300 px-4">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden transform scale-95 transition-all duration-300">
        <div class="p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-2">Tambah Kategori Baru</h3>
            <p class="text-xs text-gray-500 mb-8">Masukkan nama kategori yang unik untuk koleksi baru Anda.</p>
            
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Kategori</label>
                    <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all text-sm" placeholder="Contoh: Souvenir Pernikahan">
                </div>
                <div class="flex items-center gap-3 pt-4">
                    <button type="button" onclick="closeModal('modal-add')" class="flex-1 px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                    <button type="submit" class="flex-2 px-6 py-3 bg-pink-oke-boss text-white font-bold rounded-xl hover:bg-pink-600 shadow-lg shadow-pink-100 transition-all">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="modal-edit" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-60 flex items-center justify-center hidden opacity-0 transition-all duration-300 px-4">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden transform scale-95 transition-all duration-300">
        <div class="p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-2">Ubah Kategori</h3>
            <p class="text-xs text-gray-500 mb-8">Perbarui nama kategori yang sudah ada.</p>
            
            <form id="form-edit" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Kategori</label>
                    <input type="text" id="edit-name" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all text-sm">
                </div>
                <div class="flex items-center gap-3 pt-4">
                    <button type="button" onclick="closeModal('modal-edit')" class="flex-1 px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                    <button type="submit" class="flex-2 px-6 py-3 bg-blue-500 text-white font-bold rounded-xl hover:bg-blue-600 shadow-lg shadow-blue-100 transition-all">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="modal-delete" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-60 flex items-center justify-center hidden opacity-0 transition-all duration-300 px-4">
    <div class="bg-white w-full max-w-sm rounded-3xl shadow-2xl overflow-hidden transform scale-95 transition-all duration-300 text-center">
        <div class="p-8">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Kategori?</h3>
            <p class="text-sm text-gray-500 mb-8 leading-relaxed">Apakah Anda yakin ingin menghapus kategori <span id="delete-name" class="font-bold text-gray-900"></span>? Tindakan ini tidak dapat dibatalkan.</p>
            
            <form id="form-delete" method="POST" class="flex items-center gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModal('modal-delete')" class="flex-1 px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all">Tutup</button>
                <button type="submit" class="flex-1 px-6 py-3 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 shadow-lg shadow-red-100 transition-all">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        const container = modal.querySelector('div');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            container.classList.remove('scale-95');
        }, 10);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        const container = modal.querySelector('div');
        modal.classList.add('opacity-0');
        container.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function editCategory(id, name) {
        document.getElementById('edit-name').value = name;
        document.getElementById('form-edit').action = `/admin/categories/${id}`;
        openModal('modal-edit');
    }

    function confirmDelete(id, name) {
        document.getElementById('delete-name').innerText = name;
        document.getElementById('form-delete').action = `/admin/categories/${id}`;
        openModal('modal-delete');
    }
</script>
@endpush
@endsection
