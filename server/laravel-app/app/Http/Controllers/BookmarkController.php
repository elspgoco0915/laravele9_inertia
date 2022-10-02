<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Validator;

class BookmarkController extends Controller
{
    //
    public function index ()
    {
//        $bookmarks = [
//            [
//                'title' =>  'test',
//                'url'   =>  'https://blog.shipweb.jp/',
//            ],
//            [
//                'title' =>  'test2',
//                'url'   =>  'https://ytc.shipweb.jp/',
//            ],
//            [
//                'title' =>  'test3',
//                'url'   =>  'https://google.co.jp/',
//            ],
//        ];
//
//        return Inertia::render('Bookmark/Index', ['bookmarks' => $bookmarks]);

        return Inertia::render('Bookmark/Index', ['bookmarks' => Bookmark::all()]);

    }

    //　検索メソッド
    public function search ($queryWord)
    {
        return Inertia::render('Bookmark/Index', [
            'bookmarks' => Bookmark::where(
                                'title', 'like', '%'.$queryWord.'%'
                            )->orWhere(
                                'url', 'like', '%'.$queryWord.'%'
                            )->get()
        ]);
    }

    // 保存メソッド
    public function store (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:255', 'unique:App\Models\Bookmark,url'],
        ])->validate();

        $bookmark = new Bookmark;
        $bookmark->title = $request->title;
        $bookmark->url = $request->url;
        $bookmark->save();

        return redirect()->route('bookmark.index', $parameters = [], $status = 303, $headers = []);
    }

    // 削除メソッド
    public function destroy ($id)
    {
        Bookmark::destroy($id);
        return redirect()->route('bookmark.index', $parameters = [], $status = 303, $headers = []);

    }
}
