<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('id', 'asc')->paginate(15);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $slug = Str::slug($request->title);

        if (Page::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . uniqid();
        }

        Page::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->input('content'),
            'is_system' => false,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Pagina a fost creată cu succes.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        // Validation logic
        $rules = [
            'content' => 'nullable|string',
        ];

        // Only validate/allow title changes for non-system pages
        if (!$page->is_system) {
            $rules['title'] = 'required|string|max:255';
        }

        $request->validate($rules);

        // Protect core identity of System Pages (TOS, Return Policy)
        if (!$page->is_system) {
            $page->title = $request->title;
            $page->is_active = $request->has('is_active');
        }

        // Content is always editable (so you can update the actual text of the TOS)
        $page->content = $request->input('content');
        $page->save();

        return redirect()->route('admin.pages.index')->with('success', 'Pagina a fost actualizată.');
    }

    public function destroy(Page $page)
    {
        if ($page->is_system) {
            return back()->with('error', 'Eroare: Nu poți șterge paginile de sistem!');
        }

        $page->delete();
        return back()->with('success', 'Pagina a fost ștearsă cu succes.');
    }
}
