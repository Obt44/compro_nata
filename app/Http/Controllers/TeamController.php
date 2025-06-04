<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\TeamMember;

class TeamController extends Controller
{
    /**
     * Menampilkan halaman kelola tim
     */
    public function index()
    {
        $teamMembers = TeamMember::orderBy('order', 'asc')->get();
        
        return view('back-end.team.index', compact('teamMembers'));
    }

    /**
     * Menampilkan form tambah anggota tim
     */
    public function create()
    {
        return view('back-end.team.create');
    }

    /**
     * Menyimpan anggota tim baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'portfolio' => 'nullable|array',
            'portfolio.*' => 'nullable|string|max:255',
            'active' => 'boolean'
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('team', 'public');
        }

        // Filter out empty portfolio items
        $portfolio = array_filter($request->portfolio ?? [], function($item) {
            return !empty($item);
        });

        TeamMember::create([
            'name' => $request->name,
            'position' => $request->position,
            'photo' => $photoPath,
            'portfolio' => !empty($portfolio) ? $portfolio : null,
            'order' => TeamMember::count() + 1,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.team.index')
                        ->with('success', 'Anggota tim berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit anggota tim
     */
    public function edit($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        return view('back-end.team.edit', compact('teamMember'));
    }

    /**
     * Mengupdate anggota tim
     */
    public function update(Request $request, $id)
    {
        $teamMember = TeamMember::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'portfolio' => 'nullable|array',
            'portfolio.*' => 'nullable|string|max:255',
            'active' => 'boolean'
        ]);

        $photoPath = $teamMember->photo;
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($teamMember->photo && Storage::exists('public/' . $teamMember->photo)) {
                Storage::delete('public/' . $teamMember->photo);
            }
            
            $photoPath = $request->file('photo')->store('team', 'public');
        }

        // Filter out empty portfolio items
        $portfolio = array_filter($request->portfolio ?? [], function($item) {
            return !empty($item);
        });

        $teamMember->update([
            'name' => $request->name,
            'position' => $request->position,
            'photo' => $photoPath,
            'portfolio' => !empty($portfolio) ? $portfolio : null,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.team.index')
                        ->with('success', 'Anggota tim berhasil diperbarui!');
    }

    /**
     * Menghapus anggota tim
     */
    public function destroy($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        
        // Hapus foto jika ada
        if ($teamMember->photo && Storage::exists('public/' . $teamMember->photo)) {
            Storage::delete('public/' . $teamMember->photo);
        }
        
        $teamMember->delete();
        
        // Reorder remaining team members
        $remainingMembers = TeamMember::orderBy('order', 'asc')->get();
        foreach ($remainingMembers as $index => $member) {
            $member->update(['order' => $index + 1]);
        }
        
        return redirect()->route('admin.team.index')
                        ->with('success', 'Anggota tim berhasil dihapus!');
    }

    /**
     * Mengubah urutan anggota tim
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'required|integer|exists:team_members,id',
        ]);

        foreach ($request->orders as $index => $id) {
            TeamMember::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Mengambil data tim untuk halaman frontend
     */
    public function getTeamMembers()
    {
        $teamMembers = TeamMember::getActive();
        
        // Fetch visi and misi data
        $visi = \App\Models\Content::where('type', 'visi')->where('status', 'published')->first();
        $misi = \App\Models\Content::where('type', 'misi')->where('status', 'published')->first();
        
        return view('about', compact('teamMembers', 'visi', 'misi'));
    }
}