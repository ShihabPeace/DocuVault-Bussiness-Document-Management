<?php

/*elseif($this->){

                $Checekdexpdoc = Document::where('id', $this->)->update(['is_expired_checked' => true]);

                if ($Checekdexpdoc) {
                    dump($this->);

                    return response()->json([
                        'message' => 'checked successfully',
                    ], 200);
                }
            }elseif($this->){

                $Checekdquickid = Document::where('id', $this->)->update(['is_quick_checked' => true]);

                if ($Checekdquickid) {
                    dump($this->);

                    return response()->json([
                        'message' => 'checked successfully',
                    ], 200);
                }
            }elseif($this->){

                $Checekdpenddocid = Document::where('id', $this->)->update(['is_pending_checked' => true]);

                if ($Checekdpenddocid) {
                    dump($this->);

                    return response()->json([
                        'message' => 'checked successfully',
                    ], 200);
                }
            } */

namespace App\Http\Services;

use App\Models\Document;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Ramsey\Uuid\Type\Integer;

class Service
{
    public $modelId;
    public $model;
    public $modelName = new $model()->getclass();

    public function __construct(Integer $modelId, Model $model)
    {
        $this->modelId = $modelId;
        $this->model = $model;
    }

    public function queryExceptionReturn(QueryException $e)
    {
        return response()->json([
            'message' => 'DB error',
            'error' => $e->getMessage(),
        ], 500);
    }

    public function exceptionReturn(QueryException $e)
    {
        return response()->json([
            'message' => 'PHP error',
            'error' => $e->getMessage(),
        ], 500);
    }

    public function successReturn(Integer $s, String $msg)
    {
        return response()->json([
            'message' => $msg.'Successfully',
        ], 200);
    }

    public function deleteModel()
    {
        try {
            $res = $model::where('id', $this->modelId)->delete();

            if ($res) {
                $this->successReturn($res, 'Deleted ');
            }
        } catch (QueryException $e) {
            $this->queryExceptionReturn($e);
        } catch (Exception $e) {
            $this->exceptionReturn($e);
        }
    }

    public function pendUncheckModel() {}

    public function activityUncheckModel() {}

    public function quickUncheckModel() {}

    public function approveModel() {}

    public function cancelModel() {}
}
