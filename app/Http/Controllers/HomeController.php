<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Software;

class HomeController extends Controller
{
    public function home()
    {  $softwares = Software::with(['category', 'subcategory'])->get();
        return view('home', compact('softwares'));
    }

    public function detail(Software $software)
{
    $software->load(['category', 'subcategory']);

    switch ($software->category->name) {

        case 'Windows':
            $theme = [
                'badge' => 'bg-win-light text-win',
                'gradient' => 'from-win to-blue-700',
                'button' => 'dl-win-solid',
                'download_text' => 'Download',
                'category_text' => 'text-win',
            ];
            break;

        case 'MacOS':
            $theme = [
                'badge' => 'bg-mac-light text-mac',
                'gradient' => 'from-mac to-gray-900',
                'button' => 'bg-mac hover:bg-mac-dark text-white',
                'download_text' => 'Get',
                'category_text' => 'text-mac',
            ];
            break;

        case 'Android':
            $theme = [
                'badge' => 'bg-android-light text-android',
                'gradient' => 'from-android to-green-700',
                'button' => 'bg-android hover:bg-android-dark text-white',
                'download_text' => 'Install',
                'category_text' => 'text-android',
            ];
            break;

        default:
            $theme = [
                'badge' => 'bg-brand-light text-brand',
                'gradient' => 'from-brand to-indigo-700',
                'button' => 'bg-brand hover:bg-brand-dark text-white',
                'download_text' => 'Download',
                'category_text' => 'text-brand',
            ];
            break;
    }

    return view('detail', compact('software', 'theme'));
}

     public function category()
    {
        return view('category');
    }
    
}
