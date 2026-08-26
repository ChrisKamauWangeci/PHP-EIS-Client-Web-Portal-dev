<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AzureController extends Controller
{
    protected string $file = 'ai.txt';

    /**
     * Display the editor.
     */
    public function edit(string $id)
    {
        $content = Storage::exists($this->file)
            ? Storage::get($this->file)
            : '';

        return view('admin.azure.edit', compact('content'));
    }

    /**
     * Update the file.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
        ]);

        Storage::put($this->file, $validated['content'] ?? '');

        return redirect()
            ->route('admin.azure.edit', $id)
            ->with('success', 'File updated successfully.');
    }

    // Unused resource methods
    public function index() {}

    public function create() {}

    public function store(Request $request) {}

    public function show(string $id) {}

    public function destroy(string $id) {}
}
