<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images']);

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('roles.admins.products.index', [
            'title' => 'Data Produk',
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return view('roles.admins.products.create', [
            'title' => 'Tambah Produk',
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'weight' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:0',
            'min_order' => 'required|integer',

            'description' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'variants.*.name' => 'nullable|string',
            'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'colors.*.name' => 'nullable|string',
            'colors.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
            'min_order' => $request->min_order,
            'description' => $request->description,

        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
        }

        // Handle Variants
        if ($request->variants) {
            foreach ($request->variants as $vData) {
                if (empty($vData['name'])) continue;
                
                $vPath = null;
                if (isset($vData['image']) && $vData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $vPath = $vData['image']->store('products/variants', 'public');
                }

                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => $vData['name'],
                    'image' => $vPath
                ]);
            }
        }

        // Handle Colors
        if ($request->colors) {
            foreach ($request->colors as $cData) {
                if (empty($cData['name'])) continue;

                $cPath = null;
                if (isset($cData['image']) && $cData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $cPath = $cData['image']->store('products/colors', 'public');
                }

                ProductColor::create([
                    'product_id' => $product->id,
                    'name' => $cData['name'],
                    'image' => $cPath
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('roles.admins.products.edit', [
            'title' => 'Ubah Produk',
            'product' => $product->load(['images', 'variants', 'colors']),
            'categories' => Category::all()
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'weight' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:0',
            'min_order' => 'required|integer',

            'description' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'variants.*.id' => 'nullable',
            'variants.*.name' => 'nullable|string',
            'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'colors.*.id' => 'nullable',
            'colors.*.name' => 'nullable|string',
            'colors.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . $product->id,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
            'min_order' => $request->min_order,
            'description' => $request->description,

        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
        }

        // --- Handle Synchronization for Variants ---
        $existingVariantIds = $product->variants->pluck('id')->toArray();
        $inputVariantIds = [];
        
        if ($request->variants) {
            foreach ($request->variants as $vData) {
                if (empty($vData['name'])) continue;
                
                if (isset($vData['id']) && in_array($vData['id'], $existingVariantIds)) {
                    // Update existing
                    $variant = ProductVariant::find($vData['id']);
                    $inputVariantIds[] = (int)$vData['id'];
                    
                    $vPayload = ['name' => $vData['name']];
                    if (isset($vData['image']) && $vData['image'] instanceof \Illuminate\Http\UploadedFile) {
                        if ($variant->image) Storage::disk('public')->delete($variant->image);
                        $vPayload['image'] = $vData['image']->store('products/variants', 'public');
                    }
                    $variant->update($vPayload);
                } else {
                    // Create new
                    $vPath = null;
                    if (isset($vData['image']) && $vData['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $vPath = $vData['image']->store('products/variants', 'public');
                    }
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'name' => $vData['name'],
                        'image' => $vPath
                    ]);
                }
            }
        }
        
        // Delete variants not in input
        $toDeleteVariants = array_diff($existingVariantIds, $inputVariantIds);
        foreach ($toDeleteVariants as $dvId) {
            $dv = ProductVariant::find($dvId);
            if ($dv->image) Storage::disk('public')->delete($dv->image);
            $dv->delete();
        }

        // --- Handle Synchronization for Colors ---
        $existingColorIds = $product->colors->pluck('id')->toArray();
        $inputColorIds = [];

        if ($request->colors) {
            foreach ($request->colors as $cData) {
                if (empty($cData['name'])) continue;

                if (isset($cData['id']) && in_array($cData['id'], $existingColorIds)) {
                    // Update existing
                    $color = ProductColor::find($cData['id']);
                    $inputColorIds[] = (int)$cData['id'];

                    $cPayload = ['name' => $cData['name']];
                    if (isset($cData['image']) && $cData['image'] instanceof \Illuminate\Http\UploadedFile) {
                        if ($color->image) Storage::disk('public')->delete($color->image);
                        $cPayload['image'] = $cData['image']->store('products/colors', 'public');
                    }
                    $color->update($cPayload);
                } else {
                    // Create new
                    $cPath = null;
                    if (isset($cData['image']) && $cData['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $cPath = $cData['image']->store('products/colors', 'public');
                    }
                    ProductColor::create([
                        'product_id' => $product->id,
                        'name' => $cData['name'],
                        'image' => $cPath
                    ]);
                }
            }
        }

        // Delete colors not in input
        $toDeleteColors = array_diff($existingColorIds, $inputColorIds);
        foreach ($toDeleteColors as $dcId) {
            $dc = ProductColor::find($dcId);
            if ($dc->image) Storage::disk('public')->delete($dc->image);
            $dc->delete();
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        // Delete images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function deleteImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image);
        $image->delete();
        return back()->with('success', 'Gambar berhasil dihapus!');
    }
}
