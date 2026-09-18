<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VendorProductController extends Controller
{
    // Fetch all products for the logged-in vendor
    public function index()
    {
        $products = DB::table('products')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.products.index', compact('products'));
    }

    // Load the Add Product page
    public function create()
    {
        return view('dashboard.products.create');
    }

    // Process the form, save the image, generate Payment Link (Slug), and insert into DB
    public function store(Request $request)
    {
        // 1. Updated Validation (Notice 'image.*' to allow an array of files)
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'image.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,bmp,tiff|max:2048', // Added more formats!
            'image_urls' => 'nullable|string'
        ]);

        $imagePaths = [];

        // 2. Handle standard File Uploads (up to 3)
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                if (count($imagePaths) < 3) {
                    $imagePaths[] = $file->store('products', 'public');
                }
            }
        }

        // 3. Handle Image URLs if they were pasted instead
        if ($request->filled('image_urls')) {
            // Split URLs by new line or comma
            $urls = preg_split('/[\n,]+/', $request->image_urls);
            foreach ($urls as $url) {
                $url = trim($url);
                if (filter_var($url, FILTER_VALIDATE_URL) && count($imagePaths) < 3) {
                    $imagePaths[] = $url;
                }
            }
        }

        // 4. Save to Database
        $product = new \App\Models\Product();
        $product->user_id = auth()->id();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category = $request->category;
        $product->is_active = $request->is_active ?? 1;
        
        // Save the array as JSON for the WhatsApp Bot
        if (!empty($imagePaths)) {
            $product->image = json_encode($imagePaths);
        }

        $product->save();

        // 5. Generate the checkout slug now that we have an ID
        $product->slug = \Illuminate\Support\Str::slug($product->name) . '-' . $product->id;
        $product->save();

        return redirect()->route('vendor.products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        // Find the product, but make sure it actually belongs to the logged-in vendor!
        $product = \App\Models\Product::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        return view('dashboard.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = \App\Models\Product::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category = $request->category;
        $product->description = $request->description;
        // Checkbox handling (if unchecked, it won't be sent in request)
        $product->is_active = $request->has('is_active'); 

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('product_images', 'public');
        }

        $product->save();

        return redirect()->route('merchant.products.index')->with('success', 'Product updated successfully!');
    }

}