<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;

class PesertaController extends Controller
{
    public function index()
    {
        $pesertas = Peserta::orderBy('nama')->paginate(15);
        return view('peserta.index', compact('pesertas'));
    }

    public function create()
    {
        return view('peserta.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'uid' => 'required|string|unique:pesertas,uid',
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255'
        ]);

        Peserta::create($request->all());

        return redirect()->route('peserta.index')
                         ->with('success', 'Peserta berhasil ditambahkan!');
    }

    public function edit(Peserta $pesertum)
    {
        return view('peserta.edit', compact('pesertum'));
    }

    public function update(Request $request, Peserta $pesertum)
    {
        $request->validate([
            'uid' => 'required|string|unique:pesertas,uid,'.$pesertum->id,
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255'
        ]);

        $pesertum->update($request->all());

        return redirect()->route('peserta.index')
                         ->with('success', 'Peserta berhasil diupdate!');
    }

    public function destroy(Peserta $pesertum)
    {
        $pesertum->delete();

        return redirect()->route('peserta.index')
                         ->with('success', 'Peserta berhasil dihapus!');
    }
}
