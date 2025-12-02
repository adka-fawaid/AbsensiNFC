<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::orderBy('tanggal', 'desc')->paginate(15);
        return view('kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        return view('kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_batas_tepat' => 'required',
            'lokasi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        Kegiatan::create($request->all());

        return redirect()->route('kegiatan.index')
                         ->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function edit(Kegiatan $kegiatan)
    {
        return view('kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_batas_tepat' => 'required',
            'lokasi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        $kegiatan->update($request->all());

        return redirect()->route('kegiatan.index')
                         ->with('success', 'Kegiatan berhasil diupdate!');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();

        return redirect()->route('kegiatan.index')
                         ->with('success', 'Kegiatan berhasil dihapus!');
    }
}
