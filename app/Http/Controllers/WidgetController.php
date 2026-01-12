<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Document;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WidgetController extends Controller
{
    public function index()
    {
        // $document = Document::with('user', 'user.action')->get()->map(function ($item) {
        //     return [
        //         'id' => $item->id,
        //         'filename' => $item->filename,
        //         'link' => $item->link,
        //         'status' => $item->status,
        //         'expire_date' => $item->expire_date->format('Y-m-d g:i A'),
        //         'created_at' => $item->created_at->format('Y-m-d g:i A'),
        //         'user' => $item->user ? [
        //             'id' => $item->user->id,
        //             'role' => $item->user->role,
        //             'name' => $item->user->name,
        //             'email' => $item->user->email,
        //             'created_at' => $item->user->created_at->format('Y-m-d g:i A'),
        //             'action' => $item->user->action->map(function ($action) {
        //                 return [
        //                     'id' => $action->id,
        //                     'user_id' => $action->user_id,
        //                     'filename' => $action->filename,
        //                     'checked' => $action->checked,
        //                     'event_type' => $action->event_type,
        //                     'filename' => $action->filename,
        //                     'created_at' => $action->created_at->format('Y-m-d g:i A'),
        //                 ];
        //             }),
        //         ] : null,
        //     ];
        // });

        $documents = Document::all()->map(function ($item) {
            return [
                'id' => $item->id,
                'filename' => $item->filename,
                'link' => $item->link,
                'status' => $item->status,
                'expire_date' => $item->expire_date->format('Y-m-d g:i A'),
                'created_at' => $item->created_at->format('Y-m-d g:i A'),
            ];
        });
        $actions = Action::with('user')->get();
        return Inertia::render('dashboard', ['documents' => $documents,'actions' => $actions]);
    }

    public function checked(Request $request)
    {
        $request->validate([
            'actid' => 'required|integer|exists:actions,id',
        ]);
        try {
            $ChecekdAction = Action::where('id', $request->actid)->update(['checked' => true]);

            if ($ChecekdAction) {
                dump($request->actid);

                return response()->json([
                    'message' => 'checked successfully',
                ], 200);
            }
        } catch (QueryException $e) {
            if ($e) {
                return response()->json([
                    'message' => 'PHP error',
                    'error' => $e->getMessage(),
                ], 500);
            }
        } catch (Exception $e) {
            if ($e) {
                return response()->json([
                    'message' => 'PHP error',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

    }

    public function remove(Request $req)
    {
        $req->validate([
            'expdocid' => 'required|integer|exists:documents,id',
        ]);

        $res = Document::where('id', $req->expdocid)->delete();
        ds($res);

    }
}
