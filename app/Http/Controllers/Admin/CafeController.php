<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CafeController extends Controller
{
    public function index()
    {
        $cafes = Cafe::withCount('menus')->latest()->paginate(10);
        return view('admin.cafes.index', compact('cafes'));
    }

    public function create()
    {
        return view('admin.cafes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'menus' => 'nullable|array',
            'menus.*.name' => 'required|string|max:255',
            'menus.*.category' => 'required|in:makanan,minuman,snack',
            'menus.*.price' => 'required|numeric|min:0',
            'menus.*.description' => 'nullable|string',
            'menus.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload foto cafe
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cafes', 'public');
        }

        // Buat cafe
        $cafe = Cafe::create($validated);

        // Simpan menu jika ada
        if (isset($validated['menus']) && count($validated['menus']) > 0) {
            foreach ($validated['menus'] as $menuData) {
                if (isset($menuData['name']) && !empty($menuData['name'])) {
                    // Upload foto menu jika ada
                    if (isset($menuData['image']) && $menuData['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $menuData['image'] = $menuData['image']->store('menus', 'public');
                    } else {
                        unset($menuData['image']);
                    }
                    
                    $cafe->menus()->create($menuData);
                }
            }
        }

        return redirect()->route('admin.cafes.index')
            ->with('success', 'Cafe dan menu berhasil ditambahkan!');
    }

    public function edit(Cafe $cafe)
    {
        $cafe->load('menus');
        return view('admin.cafes.edit', compact('cafe'));
    }

    public function update(Request $request, Cafe $cafe)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'menus' => 'nullable|array',
            'menus.existing.*.id' => 'nullable|exists:menus,id',
            'menus.existing.*.name' => 'required_with:menus.existing|string|max:255',
            'menus.existing.*.category' => 'required_with:menus.existing|in:makanan,minuman,snack',
            'menus.existing.*.price' => 'required_with:menus.existing|numeric|min:0',
            'menus.existing.*.description' => 'nullable|string',
            'menus.existing.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'menus.existing.*._delete' => 'nullable|in:0,1',
            'menus.new.*._new' => 'nullable|in:1',
            'menus.new.*.name' => 'required_with:menus.new|string|max:255',
            'menus.new.*.category' => 'required_with:menus.new|in:makanan,minuman,snack',
            'menus.new.*.price' => 'required_with:menus.new|numeric|min:0',
            'menus.new.*.description' => 'nullable|string',
            'menus.new.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update cafe info
        if ($request->hasFile('image')) {
            if ($cafe->image) {
                Storage::disk('public')->delete($cafe->image);
            }
            $validated['image'] = $request->file('image')->store('cafes', 'public');
        }
        
        $cafe->update($validated);

        // Handle existing menus
        if (isset($validated['menus']['existing'])) {
            foreach ($validated['menus']['existing'] as $menuId => $menuData) {
                // Delete if marked
                if (!empty($menuData['_delete'])) {
                    $menu = $cafe->menus()->find($menuId);
                    if ($menu && $menu->image) {
                        Storage::disk('public')->delete($menu->image);
                    }
                    $menu?->delete();
                    continue;
                }
                
                // Upload new image if provided
                if (isset($menuData['image']) && $menuData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $menu = $cafe->menus()->find($menuId);
                    if ($menu && $menu->image) {
                        Storage::disk('public')->delete($menu->image);
                    }
                    $menuData['image'] = $menuData['image']->store('menus', 'public');
                } else {
                    unset($menuData['image']);
                }
                unset($menuData['_delete']);
                
                $cafe->menus()->where('id', $menuId)->update($menuData);
            }
        }

        // Handle new menus
        if (isset($validated['menus']['new'])) {
            foreach ($validated['menus']['new'] as $menuData) {
                if (empty($menuData['name'])) continue;
                
                if (isset($menuData['image']) && $menuData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $menuData['image'] = $menuData['image']->store('menus', 'public');
                } else {
                    unset($menuData['image']);
                }
                unset($menuData['_new']);
                
                $cafe->menus()->create($menuData);
            }
        }

        return redirect()->route('admin.cafes.index')
            ->with('success', 'Cafe dan menu berhasil diupdate!');
    }

    public function destroy(Cafe $cafe)
    {
        // Hapus foto cafe
        if ($cafe->image) {
            Storage::disk('public')->delete($cafe->image);
        }
        
        // Hapus semua foto menu
        foreach ($cafe->menus as $menu) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
        }
        
        $cafe->delete();

        return back()->with('success', 'Cafe dan semua menu berhasil dihapus!');
    }
}