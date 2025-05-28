<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LostController extends Controller
{
    public function index()
    {
        $lostItems = LostItem::all();
        return view('LOST', compact('lostItems'));
    }

    public function create()
    {
        return view('lost.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:20',
            'item_name' => 'required|string|max:255',
            'description' => 'required|string',
            'contact_info' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $code = '';
        for ($i = 0; $i < 9; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }

        $data = $request->all();
        // Use the provided date_lost from the hidden field
        $data['date_lost'] = $request->input('date_lost');
        // Ensure all validated data, including 'name', is passed to the model
        $lostItem = new LostItem($validatedData);
        $lostItem->reference_id = $code;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $lostItem->image = $path;
        }

        $lostItem->save();

        return redirect()->back()->with('success', 'Lost item reported successfully! Your reference code is: ' . $code . ' DO NOT LOSE THIS CODE!!!');
    }

    public function show($id)
    {
        $lostItem = LostItem::findOrFail($id);
        return view('lost.show', compact('lostItem'));
    }

    public function edit($id)
    {
        $lostItem = LostItem::findOrFail($id);
        return view('lost.edit', compact('lostItem'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:20',
            'item_name' => 'required|string|max:255',
            'description' => 'required|string',
            'contact_info' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $lostItem = LostItem::findOrFail($id);
        $lostItem->name = $request->name;
        $lostItem->student_id = $request->student_id;
        $lostItem->item_name = $request->item_name;
        $lostItem->description = $request->description;
        $lostItem->contact_info = $request->contact_info;
        $lostItem->location = $request->location;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('lost_items', 'public');
            $lostItem->image = $imagePath;
        }

        $lostItem->save();

        return redirect()->route('lost.index')->with('success', 'Your lost item has been edited successfully!');
    }

    public function destroy($id)
    {
        $lostItem = LostItem::findOrFail($id);
        $lostItem->delete();

        return redirect()->route('lost.index')->with('success', 'Lost item deleted successfully.');
    }

    public function verifyReference(Request $request, $id)
    {
        $request->validate([
            'reference_id' => 'required|string',
        ]);

        $lostItem = LostItem::findOrFail($id);

        // Normalize both values for comparison
        $inputReference = trim($request->reference_id);
        $storedReference = trim($lostItem->reference_id);

        if ($inputReference === $storedReference) {
            return redirect()->route('lost.edit', $id);
        }

        return redirect()->back()->withErrors(['reference_id' => 'Invalid Reference ID.']);
    }

    public function verifyDeleteReference(Request $request, $id)
    {
        $request->validate([
            'reference_id' => 'required|string',
        ]);

        $lostItem = LostItem::findOrFail($id);

        // Normalize both values for comparison
        $inputReference = trim($request->reference_id);
        $storedReference = trim($lostItem->reference_id);

        if ($inputReference === $storedReference) {
            $lostItem->delete();
            return redirect()->route('lost.index')->with('success', 'Lost item deleted successfully.');
        }

        return redirect()->back()->withErrors(['reference_id' => 'Invalid Reference ID.']);
    }

    // Add this method at the end of your LostController class (before the last closing bracket)
    public function markAsFound($id)
    {
        $lostItem = LostItem::findOrFail($id);
        $lostItem->status = 'found';
        $lostItem->found_at = now();
        $lostItem->save();

        return redirect()->back()->with('success', 'Item marked as found!');
    }

    public function ajaxMarkAsFound($id)
    {
        $lostItem = \App\Models\LostItem::findOrFail($id);
        $lostItem->status = 'found';
        $lostItem->found_at = now();
        $lostItem->save();

        return response()->json([
            'success' => true,
            'id' => $lostItem->id,
            'status' => $lostItem->status,
            'found_at' => $lostItem->found_at,
        ]);
    }
}
