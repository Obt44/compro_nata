<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = History::orderBy('order')->get();
        return view('back-end.history.index', compact('histories'));
    }

    public function create()
    {
        return view('back-end.history.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'order' => 'required|integer'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('histories', 'public');
        }

        History::create([
            'year' => $request->year,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'order' => $request->order
        ]);

        return redirect()->route('admin.history.index')
            ->with('success', 'Sejarah berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $history = History::findOrFail($id);
        return view('back-end.history.edit', compact('history'));
    }

    public function update(Request $request, $id)
    {
        $history = History::findOrFail($id);

        $request->validate([
            'year' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'order' => 'required|integer'
        ]);

        $imagePath = $history->image;
        if ($request->hasFile('image')) {
            if ($history->image && Storage::exists('public/' . $history->image)) {
                Storage::delete('public/' . $history->image);
            }
            $imagePath = $request->file('image')->store('histories', 'public');
        }

        $history->update([
            'year' => $request->year,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'order' => $request->order
        ]);

        return redirect()->route('admin.history.index')
            ->with('success', 'Sejarah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $history = History::findOrFail($id);

        if ($history->image && Storage::exists('public/' . $history->image)) {
            Storage::delete('public/' . $history->image);
        }

        $history->delete();

        return redirect()->route('admin.history.index')
            ->with('success', 'Sejarah berhasil dihapus!');
    }

    public function getHistories()
    {
        $histories = History::orderBy('order')->get();
        return view('partials.history', compact('histories'));
    }
}
