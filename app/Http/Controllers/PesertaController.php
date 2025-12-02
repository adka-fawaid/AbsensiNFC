<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;

/**
 * Controller untuk mengelola data peserta dalam sistem absensi NFC.
 * 
 * Menangani operasi CRUD untuk peserta termasuk validasi data,
 * manajemen UID kartu NFC, dan integrasi dengan sistem absensi.
 * 
 * @package App\Http\Controllers
 * @author Sistem Absensi NFC
 * @version 1.0.0
 */
class PesertaController extends Controller
{
    /**
     * Menampilkan daftar semua peserta.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pesertas = Peserta::orderBy('nama')->paginate(15);
        return view('peserta.index', compact('pesertas'));
    }

    /**
     * Menampilkan form untuk membuat peserta baru.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('peserta.create');
    }

    /**
     * Menyimpan data peserta baru ke database.
     * 
     * Validasi data input termasuk uniqueness untuk NIM dan UID,
     * UID bersifat nullable untuk mengakomodasi peserta yang belum memiliki kartu NFC.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dengan aturan ketat
        $request->validate([
            'uid' => 'nullable|string|unique:pesertas,uid',
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:pesertas,nim',
            'fakultas' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255'
        ]);

        // Simpan data peserta baru
        Peserta::create($request->all());

        return redirect()->route('peserta.index')
                         ->with('success', 'Peserta berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit untuk peserta yang dipilih.
     * 
     * @param \App\Models\Peserta $pesertum
     * @return \Illuminate\View\View
     */
    public function edit(Peserta $pesertum)
    {
        return view('peserta.edit', compact('pesertum'));
    }

    /**
     * Memperbarui data peserta yang sudah ada.
     * 
     * Validasi data dengan mengecualikan record yang sedang diupdate
     * untuk memastikan uniqueness NIM dan UID tetap terjaga.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Peserta $pesertum
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Peserta $pesertum)
    {
        // Validasi dengan mengecualikan record yang sedang diupdate
        $request->validate([
            'uid' => 'nullable|string|unique:pesertas,uid,'.$pesertum->id,
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:pesertas,nim,'.$pesertum->id,
            'fakultas' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255'
        ]);

        // Update data peserta
        $pesertum->update($request->all());

        return redirect()->route('peserta.index')
                         ->with('success', 'Peserta berhasil diupdate!');
    }

    /**
     * Menghapus data peserta dari database.
     * 
     * @param \App\Models\Peserta $pesertum
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Peserta $pesertum)
    {
        $pesertum->delete();

        return redirect()->route('peserta.index')
                         ->with('success', 'Peserta berhasil dihapus!');
    }


}
