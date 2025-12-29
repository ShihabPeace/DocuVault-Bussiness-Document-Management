<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Inertia\Inertia;

class WidgetController extends Controller
{
    public function index()
    {
        // $document = Document::with('user','user.action')->get();
        $document = Document::with('user','user.action')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'content' => $item->content,
                'link' => $item->link,
                'user' => $item->user,
                'checked' => $item->checked,
                'status' => $item->status,
                'created_at' => $item->created_at->format('Y-m-d g:i A'),
                'user' ->
            ];
        });
        // dump($document);
        // foreach($document as $doc) {
        //     foreach($doc->user->action as $action) {
        //         dump($action->event_type);
        //     }
        // }
        return Inertia::render('dashboard', ['documents' => $document]);
    }
}
