@extends('layouts.admin')

@section('admin_container')
<div class="space-y-8 max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Ubah Produk</h2>
            <p class="text-sm text-gray-500">Perbarui detail produk souvenir Anda.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all text-sm">Kembali</a>
    </div>

    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
        <div class="flex">
            <div class="shrink-0 text-red-400">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            </div>
            <ul class="ml-3 text-sm text-red-700 list-disc list-inside font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        @method('PATCH')
        <!-- Left Column: Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-8 rounded-4xl border border-gray-100 shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-50 pb-4">Informasi Utama</h3>
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all text-sm font-semibold" placeholder="Masukkan nama produk souvenir">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all text-sm font-bold" placeholder="Contoh: 15000">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Berat (Gram)</label>
                        <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all text-sm font-bold" placeholder="Contoh: 500">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Stok Total</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all text-sm font-bold" placeholder="Jumlah stok">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Minimum Order (Pcs)</label>
                        <input type="number" name="min_order" value="{{ old('min_order', $product->min_order) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all text-sm font-bold" placeholder="Contoh: 100">
                    </div>
                </div>


                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Deskripsi Produk</label>
                    <textarea name="description" rows="6" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all text-sm leading-relaxed" placeholder="Jelaskan detail produk, bahan, ukuran, dll...">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <!-- Existing Images Gallery -->
            <div class="bg-white p-8 rounded-4xl border border-gray-100 shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-50 pb-4">Galeri Gambar Saat Ini</h3>
                @if($product->images->isEmpty())
                <p class="text-sm text-gray-500 text-center py-4 italic">Belum ada gambar.</p>
                @else
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($product->images as $image)
                    <div class="relative group aspect-square rounded-2xl overflow-hidden border border-gray-100">
                        <img src="{{ asset('storage/' . $image->image) }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <button type="button" 
                                onclick="if(confirm('Hapus gambar ini?')) document.getElementById('delete-image-{{ $image->id }}').submit();"
                                class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all shadow-lg active:scale-90">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Variants Section -->
            <div class="bg-white p-8 rounded-4xl border border-gray-100 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-gray-50 pb-4">
                    <h3 class="text-lg font-bold text-gray-900">Variasi Produk (Tema/Jenis)</h3>
                    <button type="button" onclick="addRow('variant')" class="px-4 py-2 bg-pink-50 text-pink-600 rounded-xl text-xs font-bold hover:bg-pink-100 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Variasi
                    </button>
                </div>
                <div id="variant-container" class="space-y-4">
                    @forelse($product->variants as $index => $variant)
                    <div class="flex gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100 relative group" id="variant-row-{{ $index }}">
                        <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                        <div class="w-16 h-16 bg-white rounded-xl border border-gray-200 overflow-hidden relative shrink-0 group/img">
                            <input type="file" name="variants[{{ $index }}][image]" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewRowImage(this, 'variant-preview-{{ $index }}')">
                            <img id="variant-preview-{{ $index }}" src="{{ $variant->image ? asset('storage/' . $variant->image) : '' }}" class="w-full h-full object-cover {{ $variant->image ? '' : 'hidden' }}">
                            <div class="absolute inset-0 flex items-center justify-center text-gray-300 pointer-events-none group-hover/img:text-pink-400 transition-colors {{ $variant->image ? 'hidden' : '' }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        </div>
                        <div class="flex-1 space-y-2">
                            <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Nama Variasi</label>
                            <input type="text" name="variants[{{ $index }}][name]" value="{{ $variant->name }}" required class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 outline-none text-sm font-semibold" placeholder="Masukkan nama...">
                        </div>
                        <button type="button" onclick="removeRow('variant', {{ $index }})" class="absolute -top-2 -right-2 w-6 h-6 bg-white shadow-sm border border-gray-100 rounded-full flex items-center justify-center text-red-500 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    @empty
                    <div class="text-center py-6 border-2 border-dashed border-gray-50 rounded-2xl" id="variant-empty">
                        <p class="text-xs text-gray-400 font-medium">Belum ada variasi ditambahkan.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Colors Section -->
            <div class="bg-white p-8 rounded-4xl border border-gray-100 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-gray-50 pb-4">
                    <h3 class="text-lg font-bold text-gray-900">Pilihan Warna</h3>
                    <button type="button" onclick="addRow('color')" class="px-4 py-2 bg-pink-50 text-pink-600 rounded-xl text-xs font-bold hover:bg-pink-100 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Warna
                    </button>
                </div>
                <div id="color-container" class="space-y-4">
                    @forelse($product->colors as $index => $color)
                    <div class="flex gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100 relative group" id="color-row-{{ $index }}">
                        <input type="hidden" name="colors[{{ $index }}][id]" value="{{ $color->id }}">
                        <div class="w-16 h-16 bg-white rounded-xl border border-gray-200 overflow-hidden relative shrink-0 group/img">
                            <input type="file" name="colors[{{ $index }}][image]" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewRowImage(this, 'color-preview-{{ $index }}')">
                            <img id="color-preview-{{ $index }}" src="{{ $color->image ? asset('storage/' . $color->image) : '' }}" class="w-full h-full object-cover {{ $color->image ? '' : 'hidden' }}">
                            <div class="absolute inset-0 flex items-center justify-center text-gray-300 pointer-events-none group-hover/img:text-pink-400 transition-colors {{ $color->image ? 'hidden' : '' }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        </div>
                        <div class="flex-1 space-y-2">
                            <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Nama Warna</label>
                            <input type="text" name="colors[{{ $index }}][name]" value="{{ $color->name }}" required class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 outline-none text-sm font-semibold" placeholder="Masukkan nama...">
                        </div>
                        <button type="button" onclick="removeRow('color', {{ $index }})" class="absolute -top-2 -right-2 w-6 h-6 bg-white shadow-sm border border-gray-100 rounded-full flex items-center justify-center text-red-500 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    @empty
                    <div class="text-center py-6 border-2 border-dashed border-gray-50 rounded-2xl" id="color-empty">
                        <p class="text-xs text-gray-400 font-medium">Belum ada pilihan warna ditambahkan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Meta & Media -->
        <div class="space-y-6">
            <!-- Category Box -->
            <div class="bg-white p-8 rounded-4xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-gray-900">Kategori</h3>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Pilih Kategori</label>
                    <select name="category_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-pink-500 focus:bg-white transition-all text-sm font-semibold appearance-none">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Image Upload Box -->
            <div class="bg-white p-8 rounded-4xl border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">Media Utama</h3>
                    <span class="text-[10px] bg-blue-50 text-blue-500 px-2 py-1 rounded-lg font-bold">Unggah Banyak</span>
                </div>
                <div class="space-y-4">
                    <div class="relative group border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center hover:border-pink-500 transition-all bg-gray-50/50">
                        <input type="file" name="images[]" id="image-input" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewImages(this)">
                        <div class="space-y-2 pointer-events-none">
                            <div class="w-12 h-12 bg-white rounded-xl shadow-xs border border-gray-100 flex items-center justify-center mx-auto text-pink-500 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-900">Tambah Gambar Produk</p>
                            <p class="text-[10px] text-gray-400">Pilih gambar baru untuk ditambahkan</p>
                        </div>
                    </div>
                    
                    <!-- Preview Container -->
                    <div id="preview-container" class="grid grid-cols-3 gap-2 mt-4 hidden">
                        <!-- New previews injected here -->
                    </div>
                </div>
            </div>

            <!-- Submit Box -->
            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-pink-oke-boss text-white font-extrabold rounded-2xl hover:bg-pink-600 shadow-xl shadow-pink-100 transition-all hover:-translate-y-1 active:scale-95 text-sm tracking-wide">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Hidden Delete Image Forms -->
@foreach($product->images as $image)
<form id="delete-image-{{ $image->id }}" action="{{ route('admin.products.delete-image', $image->id) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endforeach

@push('scripts')
<script>
    let variantCount = {{ $product->variants->count() }};
    let colorCount = {{ $product->colors->count() }};

    function addRow(type) {
        const container = document.getElementById(`${type}-container`);
        const emptyState = document.getElementById(`${type}-empty`);
        const index = type === 'variant' ? variantCount++ : colorCount++;
        
        if (emptyState) emptyState.classList.add('hidden');

        const div = document.createElement('div');
        div.className = `flex gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100 relative group animate-in fade-in slide-in-from-top-4 duration-300`;
        div.id = `${type}-row-${index}`;
        
        div.innerHTML = `
            <div class="w-16 h-16 bg-white rounded-xl border border-gray-200 overflow-hidden relative shrink-0 group/img">
                <input type="file" name="${type}s[${index}][image]" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewRowImage(this, '${type}-preview-${index}')">
                <img id="${type}-preview-${index}" src="" class="w-full h-full object-cover hidden">
                <div class="absolute inset-0 flex items-center justify-center text-gray-300 pointer-events-none group-hover/img:text-pink-400 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="flex-1 space-y-2">
                <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Nama ${type === 'variant' ? 'Variasi' : 'Warna'}</label>
                <input type="text" name="${type}s[${index}][name]" required class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 outline-none text-sm font-semibold" placeholder="Masukkan nama...">
            </div>
            <button type="button" onclick="removeRow('${type}', ${index})" class="absolute -top-2 -right-2 w-6 h-6 bg-white shadow-sm border border-gray-100 rounded-full flex items-center justify-center text-red-500 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        `;
        
        container.appendChild(div);
    }

    function removeRow(type, index) {
        const row = document.getElementById(`${type}-row-${index}`);
        row.remove();
        
        const container = document.getElementById(`${type}-container`);
        const rows = container.querySelectorAll(`[id^="${type}-row-"]`);
        if (rows.length === 0) {
            const emptyState = document.getElementById(`${type}-empty`);
            if (emptyState) emptyState.classList.remove('hidden');
            else {
                container.innerHTML = `<div class="text-center py-6 border-2 border-dashed border-gray-50 rounded-2xl" id="${type}-empty"><p class="text-xs text-gray-400 font-medium">Belum ada ${type === 'variant' ? 'variasi' : 'warna'} ditambahkan.</p></div>`;
            }
        }
    }

    function previewRowImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                const placeholder = preview.nextElementSibling;
                if (placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewImages(input) {
        const container = document.getElementById('preview-container');
        container.innerHTML = '';
        
        if (input.files && input.files.length > 0) {
            container.classList.remove('hidden');
            
            Array.from(input.files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative aspect-square rounded-xl overflow-hidden border border-gray-100 group';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <span class="absolute top-1 left-1 bg-blue-500 text-white text-[8px] font-bold px-1.5 py-0.5 rounded-md shadow-sm italic">Baru</span>
                    `;
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        } else {
            container.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection
