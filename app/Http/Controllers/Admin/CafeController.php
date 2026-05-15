<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cafe;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // Pastikan import ini ada

class CafeController extends Controller
{
    public function index(Request $request)
    {
        $query = Cafe::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('address', 'LIKE', "%{$search}%");
            });
        }
        
        switch ($request->get('sort', 'latest')) {
            case 'name_asc': $query->orderBy('name', 'ASC'); break;
            case 'name_desc': $query->orderBy('name', 'DESC'); break;
            case 'oldest': $query->oldest(); break;
            default: $query->latest();
        }
        
        return view('admin.cafes.index', [
            'cafes' => $query->paginate(10)->withQueryString()
        ]);
    }

    public function create()
    {
        return view('admin.cafes.create');
    }

    public function store(Request $request)
    {
        // ✅ FIX: Hapus ->whereNull('deleted_at')
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('cafes', 'name')],
            'address' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string', 'min:20', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ], [
            'name.unique' => 'Nama cafe sudah terdaftar.',
            'description.min' => 'Deskripsi minimal 20 karakter.',
            'image.mimes' => 'Format gambar harus JPG/PNG.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);
        
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $validated['image'] = $request->file('image')->store('cafes', 'public');
        }
        
        Cafe::create($validated);
        
        return redirect()->route('admin.cafes.index')
            ->with('success', '✅ Cafe "'.$validated['name'].'" berhasil ditambahkan!');
    }

    public function edit(Cafe $cafe)
    {
        return view('admin.cafes.edit', compact('cafe'));
    }

    public function update(Request $request, Cafe $cafe)
    {
        // ✅ FIX: Hapus ->whereNull('deleted_at')
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('cafes', 'name')->ignore($cafe->id)],
            'address' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string', 'min:20', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ], [
            'name.unique' => 'Nama cafe sudah digunakan cafe lain.',
            'description.min' => 'Deskripsi minimal 20 karakter.',
            'image.mimes' => 'Format gambar harus JPG/PNG.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);
        
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($cafe->image && Storage::disk('public')->exists($cafe->image)) {
                Storage::disk('public')->delete($cafe->image);
            }
            $validated['image'] = $request->file('image')->store('cafes', 'public');
        }
        
        $cafe->update($validated);
        
        return redirect()->route('admin.cafes.index')
            ->with('success', '✨ Cafe "'.$cafe->name.'" berhasil diperbarui!');
    }

    public function destroy(Cafe $cafe)
    {
        if ($cafe->image && Storage::disk('public')->exists($cafe->image)) {
            Storage::disk('public')->delete($cafe->image);
        }
        
        $cafe->delete();
        
        return redirect()->route('admin.cafes.index')
            ->with('success', '🗑️ Cafe berhasil dihapus.');
    }
}