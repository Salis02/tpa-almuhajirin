<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%")
                ->orWhere('category', 'like', "%{$request->search}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $documents = $query->latest()->paginate(10);

        // daftar kategori default (bisa ditambah sesuai kebutuhan)
        $categories = ['Administrasi', 'Keuangan', 'Kurikulum', 'Kegiatan', 'Lainnya'];

        return view('documents.index', compact('documents', 'categories'));
    }


    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $path = $request->file('file')->store('documents', 'public');

        Document::create([
            'title' => $request->title,
            'file_path' => $path,
            'category' => $request->category,
            'description' => $request->description,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('document.index')->with('success', 'Dokumen berhasil diupload');
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $data = [
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
        ];

        // Kalau ada file baru, replace file lama
        if ($request->hasFile('file')) {
            // hapus file lama
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            // upload file baru
            $data['file_path'] = $request->file('file')->store('documents', 'public');
        }

        $document->update($data);

        return redirect()->route('document.index')->with('success', 'Dokumen berhasil diperbarui');
    }

    public function destroy(Document $document)
    {
        Storage::delete($document->file_path);
        $document->delete();

        return redirect()->route('document.index')->with('success', 'Dokumen berhasil dihapus');
    }
}
