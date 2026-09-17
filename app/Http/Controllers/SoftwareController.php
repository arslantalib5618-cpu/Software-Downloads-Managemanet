<?php

namespace App\Http\Controllers;

use App\Models\Software;
use App\Models\Category;
use App\Models\Subcategory;
use App\Http\Requests\StoreSoftwareRequest;
use App\Http\Requests\UpdateSoftwareRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Newsletter;
use App\Mail\NewPostPublished;
use Illuminate\Support\Facades\Mail;

class SoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function index()
{
    $softwares = Software::with(['category', 'subcategory'])
        ->latest()
        ->paginate(10);

    return view('admin.softwares.index', compact('softwares'));
}

    /**
     * Show the form for creating a new resource.
     */
    

public function create()
{
    $categories = Category::orderBy('name')->get();

    $subcategories = Subcategory::orderBy('name')->get();

    return view('admin.softwares.create', compact(
        'categories',
        'subcategories'
    ));
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(StoreSoftwareRequest $request)
{
    $data = $request->validated();

    /*
    |--------------------------------------------------------------------------
    | Upload Software Icon
    |--------------------------------------------------------------------------
    */
    if ($request->hasFile('icon')) {
        $data['icon'] = $request->file('icon')->store('media/icons', 'public');
    }

    /*
    |--------------------------------------------------------------------------
    | Upload Screenshots
    |--------------------------------------------------------------------------
    */
    $screenshots = [];

    if ($request->hasFile('screenshots')) {
        foreach ($request->file('screenshots') as $image) {
            $screenshots[] = $image->store('media/screenshots', 'public');
        }

        $data['screenshots'] = $screenshots;
    }

    /*
    |--------------------------------------------------------------------------
    | Default Button Text
    |--------------------------------------------------------------------------
    */
    $data['download_button_text'] = $request->download_button_text ?: 'Download Now';
    $data['official_button_text'] = $request->official_button_text ?: 'Official Website';
$data['downloads_count'] = $data['downloads_count'] ?? 0;
$data['rating'] = $data['rating'] ?? 0;
    /*
    |--------------------------------------------------------------------------
    | Generate Slug Automatically (if empty)
    |--------------------------------------------------------------------------
    */
    if (empty($data['slug'])) {
        $data['slug'] = Str::slug($data['title']);
    }

    /*
    |--------------------------------------------------------------------------
    | Save Software
    |--------------------------------------------------------------------------
    */
    // Software::create($data);

    


/*
|--------------------------------------------------------------------------
| Send Email To Subscribers
|--------------------------------------------------------------------------
*/

 $software =  Software::create($data);

$subscribers = Newsletter::all();



foreach ($subscribers as $subscriber) {


    Mail::to($subscriber->email)
        ->send(new NewPostPublished($software));

}

    return redirect()
        ->route('softwares.index')
        ->with('success', 'Software added successfully.');
}
    /**
     * Display the specified resource.
     */
    public function show(Software $software)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Software $software)
    {
        $categories = Category::orderBy('name')->get();
        $subcategories = Subcategory::orderBy('name')->get();

        return view('admin.softwares.edit', compact(
            'software',
            'categories',
            'subcategories'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateSoftwareRequest $request, Software $software)
{
    $data = $request->validated();

    // Upload new icon
    if ($request->hasFile('icon')) {

        if ($software->icon) {
            Storage::disk('public')->delete($software->icon);
        }

        $data['icon'] = $request->file('icon')->store('media/icons', 'public');
    }

    // Upload new screenshots
    if ($request->hasFile('screenshots')) {

        if (!empty($software->screenshots)) {
            foreach ($software->screenshots as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $screenshots = [];

        foreach ($request->file('screenshots') as $image) {
            $screenshots[] = $image->store('media/screenshots', 'public');
        }

        $data['screenshots'] = $screenshots;
    }

    // Auto generate slug if empty
    if (empty($data['slug'])) {
        $data['slug'] = Str::slug($data['title']);
    }

    $software->update($data);

    return redirect()
        ->route('softwares.index')
        ->with('success', 'Software updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Software $software)
{
    // Delete icon
    if ($software->icon) {
        Storage::disk('public')->delete($software->icon);
    }

    // Delete screenshots
    if (!empty($software->screenshots)) {
        foreach ($software->screenshots as $image) {
            Storage::disk('public')->delete($image);
        }
    }

    // Delete record
    $software->delete();

    return redirect()
        ->route('softwares.index')
        ->with('success', 'Software deleted successfully.');
}
}
