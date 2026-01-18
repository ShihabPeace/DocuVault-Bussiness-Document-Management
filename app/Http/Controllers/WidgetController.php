<?php

namespace App\Http\Controllers;

use App\Enums\EnumsAction;
use App\Enums\EnumsStatus;
use App\Models\Action;
use App\Models\Document;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

use function Illuminate\Log\log;
use function Symfony\Component\String\u;

class WidgetController extends Controller
{
    public function dashboardIndex()
    {
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

        return Inertia::render('dashboard', ['documents' => $documents, 'actions' => $actions]);
    }

    public function Uncheck(Request $request)
    {
        $request->validate([
            'actid' => 'integer|exists:actions,id',
            'expdocid' => 'integer|exists:documents,id',
            'pendingid' => 'integer|exists:documents,id',
            'quickid' => 'integer|exists:documents,id',
        ]);
        try {
            if($request->actid){

                $ChecekdAction = Action::where('id', $request->actid)->update(['checked' => true]);
    
                if ($ChecekdAction) {
                    dump($request->actid);
    
                    return response()->json([
                        'message' => 'checked successfully',
                    ], 200);
                }
            }elseif($request->expdocid){
                
                $Checekdexpdoc = Document::where('id', $request->expdocid)->update(['is_expired_checked' => true]);

                if ($Checekdexpdoc) {
                    dump($request->actid);
    
                    return response()->json([
                        'message' => 'checked successfully',
                    ], 200);
                }
            }elseif($request->quickid){
                
                $Checekdquickid = Document::where('id', $request->quickid)->update(['is_quick_checked' => true]);
    
                if ($Checekdquickid) {
                    dump($request->actid);
    
                    return response()->json([
                        'message' => 'checked successfully',
                    ], 200);
                }
            }elseif($request->penddocid){
                
                $Checekdpenddocid = Document::where('id', $request->penddocid)->update(['is_pending_checked' => true]);
    
                if ($Checekdpenddocid) {
                    dump($request->actid);
    
                    return response()->json([
                        'message' => 'checked successfully',
                    ], 200);
                }
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
 
        $expdoc = Document::where('id', $req->expdocid)->get();
        Action::create([
            'filename' => $expdoc->filename,
            'user_id' => Auth::id(),
            'checked' => false,
            'event_type' => EnumsAction::DELETE,
        ]);


    }

    public function approve(Request $req)
    {
        $req->validate([
            'penddocid' => 'required|integer|exists:documents,id',
        ]);

        $res = Document::where('id', $req->penddocid)->update('status', EnumsStatus::PENDING);
    }

    public function cancel(Request $req)
    {
        $req->validate([
            'penddocid' => 'required|integer|exists:documents,id',
        ]);

        $res = Document::where('id', $req->penddocid)->update('status', EnumsStatus::CANCELLED);
    }
    public function test(Request $req)
    {
        $req->validate([
            'testint' => 'required|integer|exists:users,id',
        ]);

        $m = 'Document';
        $model = new $m();
        $user = $model->find($req->testint);
        dd($user);
    }
}
/*
docuvault.test/test/1
*/
