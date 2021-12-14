<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiNews;
use App\Models\Category;
use App\Models\News;
use Illuminate\Support\Facades\Auth;

class ApiCodeController extends Controller
{
    public function index()
    {
        $queryString = http_build_query([
            'access_key' => '5754a7b1ec712dbbc4767a7ee2c606ae',
            'languages' => 'en',
            'limit' => '100',
            // 'keywords' => 'Wall street -wolf', // the word "wolf" will be
            // 'categories' => 'general',
            'categories' => 'entertainment',
            // 'categories' => 'sports',
            'sort' => 'popularity',
        ]);
        $ch = curl_init(sprintf('%s?%s', 'http://api.mediastack.com/v1/news', $queryString));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);
        $news = json_decode($json, true);
        //   return $news;
        return view('api.api-news', compact('news'));
    }





    public function store(Request $request)
    {
        $queryString = http_build_query([
            'access_key' => '5754a7b1ec712dbbc4767a7ee2c606ae',
            'languages' => 'en',
            // 'limit' => '100',
            // 'keywords' => 'Wall street -wolf', // the word "wolf" will be
            'categories' => 'entertainment',
            'sort' => 'popularity',
        ]);
        $ch = curl_init(sprintf('%s?%s', 'http://api.mediastack.com/v1/news', $queryString));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);
        $apiNews = json_decode($json, true);
        for ($i = 0; $i < count($apiNews['data']); $i++) {
            $checkcat = Category::where('title', $apiNews['data'][$i]['category'])->first();
            // $dbnews = News::select('title')->get();
            $dbnews = News::where('title', $apiNews['data'][$i]['title'])->first();
            // return ($dbnews);
            if ($checkcat) {
                if (!$dbnews) {
                    $news = new News([
                        'author_name' => $apiNews['data'][$i]['author'],
                        'title' => $apiNews['data'][$i]['title'],
                        'news' => $apiNews['data'][$i]['description'],
                        'category_id' => $checkcat->id,
                        'status' => 'active',
                        'image' => $apiNews['data'][$i]['image'],
                        'user_id' => Auth::user()->id,
                    ]);
                    $news->save();
                }
            } else {

                Category::create([
                    'title' => $apiNews['data'][$i]['category'],
                    'description' =>   "NULL",
                    'category_image' => "Null",
                    'created_by' => Auth::user()->id,
                ]);
                $checkcat = Category::where('title', $apiNews['data'][$i]['category'])->first();
                $news = new News([
                    'author_name' => $apiNews['data'][$i]['author'],
                    'title' => $apiNews['data'][$i]['title'],
                    'news' => $apiNews['data'][$i]['description'],
                    'category_id' => $checkcat->id,
                    'status' => 'active',
                    'image' => $apiNews['data'][$i]['image'],
                    'user_id' => Auth::user()->id,
                ]);
                $news->save();
            }
        }
        return redirect('/');
    }
}





    // for ($i = 0; $i <= count(100); $i++)


        //     {
        //         for ($i = 0; $i < 100; $i++){
        //             $news =new News([
        //                 'author_name' => 'author hasnain',
        //                 'title' => 'demo title',
        //                 'news' => '100 news',
        //                 'category_id' => '6',
        //                 'status' => 'active',
        //                 'image' => 'image',
        //                 'user_id' =>  '4',
        //             ]);
        //             //  $news->user_id = Auth::user()->id;
        //                 $news->save();
        //         }

        // }


















































        // public function index()
        // {
        //     $queryString = http_build_query([
        //         'access_key' => '5754a7b1ec712dbbc4767a7ee2c606ae',
        //         'languages' => 'en',
        //         'limit' => '100',
        //         // 'keywords' => 'Wall street -wolf', // the word "wolf" will be
        //         'categories' => 'general',
        //         // 'categories' => 'sports',
        //         'sort' => 'popularity',
        //     ]);
        //     $ch = curl_init(sprintf('%s?%s', 'http://api.mediastack.com/v1/news', $queryString));
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     $json = curl_exec($ch);
        //     curl_close($ch);
        //     $news = json_decode($json, true);
        //     //   return $news;
        //     return view('api.api-news', compact('news'));
        // }






    // public function store(Request $request)
    // {
    //     $queryString = http_build_query([
    //         'access_key' => '5754a7b1ec712dbbc4767a7ee2c606ae',
    //         'languages' => 'en',
    //         // 'limit' => '100',
    //         // 'keywords' => 'Wall street -wolf', // the word "wolf" will be
    //         'categories' => 'general',
    //         // 'categories' => 'sports',
    //         'sort' => 'popularity',
    //     ]);

    //     $ch = curl_init(sprintf('%s?%s', 'http://api.mediastack.com/v1/news', $queryString));
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     $json = curl_exec($ch);

    //     curl_close($ch);

    //     $apiNews = json_decode($json, true);
    //     // return $apiNews;
    //     $news =  $apiNews['data'];
    //     //   return $news;
    //     //    return $news;
    //     for ($i = 0; $i <= count($news); $i++) {
    //         $checkcat = Category::where('title', $news[$i]['category'])->first();

    //         if ($checkcat) {
    //             $news = new News([
    //                 'author_name' => $news[$i]['author'],
    //                 'title' => $news[$i]['title'],
    //                 'news' => $news[$i]['description'],
    //                 'category_id' => $checkcat->id,
    //                 'status' => 'active',
    //                 'image' => $news[$i]['image'],
    //                 'user_id' => Auth::user()->id,
    //             ]);
    //             $news->save();
    //         } else {

    //             Category::create([
    //                 'title' => $news[$i]['category'],
    //                 'description' =>   "NULL",
    //                 'category_image' => "Null",
    //                 'created_by' => Auth::user()->id,
    //             ]);
    //             $checkcat = Category::where('title', $news[$i]['category'])->first();
    //             $news = new News([
    //                 'author_name' => $news[$i]['author'],
    //                 'title' => $news[$i]['title'],
    //                 'news' => $news[$i]['description'],
    //                 'category_id' => $checkcat->id,
    //                 'status' => 'active',
    //                 'image' => $news[$i]['image'],
    //                 'user_id' => Auth::user()->id,
    //             ]);
    //             $news->save();
    //         }





    // public function store(Request $request)
    // {
    //     $queryString = http_build_query([
    //         'access_key' => '5754a7b1ec712dbbc4767a7ee2c606ae',
    //         'languages' => 'en',
    //         'limit' => '100',
    //         // 'keywords' => 'Wall street -wolf', // the word "wolf" will be
    //         // 'categories' => 'general',
    //         // 'categories' => 'business',
    //         // 'categories' => 'entertainment',
    //         // 'categories' => 'health',
    //         // 'categories' => 'science'.
    //         // 'categories' => 'technology',
    //         'categories' => 'sports',
    //         'sort' => 'popularity',
    //     ]);
    //     $ch = curl_init(sprintf('%s?%s', 'http://api.mediastack.com/v1/news', $queryString));
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $json = curl_exec($ch);
    //     curl_close($ch);
    //     $apiNews = json_decode($json, true);
    //     for ($i = 0; $i < count($apiNews['data']); $i++) {
    //         $checkcat = Category::where('title', $apiNews['data'][$i]['category'])->first();
    //         if ($checkcat) {
    //             $news = new News([
    //                 'author_name' => $apiNews['data'][$i]['author'],
    //                 'title' => $apiNews['data'][$i]['title'],
    //                 'news' => $apiNews['data'][$i]['description'],
    //                 'category_id' => $checkcat->id,
    //                 'status' => 'active',
    //                 'image' => $apiNews['data'][$i]['image'],
    //                 'user_id' => Auth::user()->id,
    //             ]);
    //             $news->save();
    //         } else {
    //             Category::create([
    //                 'title' => $apiNews['data'][$i]['category'],
    //                 'description' =>   "NULL",
    //                 'category_image' => "Null",
    //                 'created_by' => Auth::user()->id,
    //             ]);
    //             $checkcat = Category::where('title', $apiNews['data'][$i]['category'])->first();
    //             $news = new News([
    //                 'author_name' => $apiNews['data'][$i]['author'],
    //                 'title' => $apiNews['data'][$i]['title'],
    //                 'news' => $apiNews['data'][$i]['description'],
    //                 'category_id' => $checkcat->id,
    //                 'status' => 'active',
    //                 'image' => $apiNews['data'][$i]['image'],
    //                 'user_id' => Auth::user()->id,
    //             ]);
    //             $news->save();
    //         }
    //     }
    //     return redirect('/');
    // }


// public function store(Request $request)
// {
//     $queryString = http_build_query([
//         'access_key' => '5754a7b1ec712dbbc4767a7ee2c606ae',
//         'languages' => 'en',
//         'limit' => '100',
//         // 'keywords' => 'Wall street -wolf', // the word "wolf" will be
//         // 'categories' => 'general',
//         // 'categories' => 'business',
//         // 'categories' => 'entertainment',
//         // 'categories' => 'health',
//         // 'categories' => 'science'.
//         // 'categories' => 'technology',
//         'categories' => 'sports',
//         'sort' => 'popularity',
//     ]);
//     $ch = curl_init(sprintf('%s?%s', 'http://api.mediastack.com/v1/news', $queryString));
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     $json = curl_exec($ch);
//     curl_close($ch);
//     $apiNews = json_decode($json, true);
//     for ($i = 0; $i < count($apiNews['data']); $i++) {
//         $checkcat = Category::where('title', $apiNews['data'][$i]['category'])->first();
//         $dbnews = News::select('title')->get();
//         // $checkcat = News::where('title', $apiNews['data'][$i]['title'])->first();

//         if ($checkcat) {
//             if(  $dbnews[$i]['title'] !=  $apiNews['data'][$i]['title']){
//                 $news = new News([
//                     'author_name' => $apiNews['data'][$i]['author'],
//                     'title' => $apiNews['data'][$i]['title'],
//                     'news' => $apiNews['data'][$i]['description'],
//                     'category_id' => $checkcat->id,
//                     'status' => 'active',
//                     'image' => $apiNews['data'][$i]['image'],
//                     'user_id' => Auth::user()->id,
//                 ]);
//                 $news->save();
//             }

//         } else {

//             Category::create([
//                 'title' => $apiNews['data'][$i]['category'],
//                 'description' =>   "NULL",
//                 'category_image' => "Null",
//                 'created_by' => Auth::user()->id,
//             ]);
//             $checkcat = Category::where('title', $apiNews['data'][$i]['category'])->first();
//             // $checkcat = News::where('title', $apiNews['data'][$i]['title'])->first();

//             $news = new News([
//                 'author_name' => $apiNews['data'][$i]['author'],
//                 'title' => $apiNews['data'][$i]['title'],
//                 'news' => $apiNews['data'][$i]['description'],
//                 'category_id' => $checkcat->id,
//                 'status' => 'active',
//                 'image' => $apiNews['data'][$i]['image'],
//                 'user_id' => Auth::user()->id,
//             ]);
//             $news->save();
//         }
//     }
//     return redirect('/');
// }
// }
