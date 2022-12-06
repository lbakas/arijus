<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\OrderTransformer;
use App\Models\Order;
use Validator;


class OrdersController extends FractalController
{
    function __construct(OrderTransformer $partTransformer, Request $request)
    {
        parent::__construct($partTransformer, $request);
    }

    public function list() {
        $inputs = $this->request->all();

        $query = Order::query();

        $query->orderBy('created_at', 'desc');

        return $this->SimpleResponse($query->get());
    }

    public function show($id)
    {
        return $this->SingleResponse(Order::find($id));
    }

    public function update($id)
    {
        $inputs = $this->request->all();
        $model = Order::find($id);
        if (!$model) \App::abort(404);
        \DB::beginTransaction();
        list($model, $ok)  = $this->validateAndSet($model);

        if ($ok) {
            try {
                if ($model->save()) {
                    \DB::commit();
                }
            } catch (Exception $e) {
                $this->setErrors($e->getMessage());
                \DB::rollback();
            } finally {

            }
        } else {
            \DB::rollback();
        }

        return $this->SingleResponse($model);
    }

    public function store()
    {
        $model = new Order;
        $this->saveModel($model);
        return $this->SingleResponse($model);
    }

    private function saveModel($model)
    {
        $inputs = $this->request->all();

        $model->fill($inputs);

        $validator = Validator::make($inputs, Order::$rules);

        if (!$validator->fails()) {
            try {
                $model->save();
            } catch (Exception $e) {
                $this->setErrors($e->getMessage());
            } finally {

            }
        } else {
            $this->setErrors($validator->errors());
        }
    }

    public function delete($id)
    {
        $model = Order::find($id);

        return [
            'success' => ((!$model) || ($model->delete())),
            'message' => ''
        ];
    }

    private function validateAndSet(Order $model) {
        $inputs = $this->request->all();

        $model->fill($inputs);
//        dd($inputs, $model->getAttributes());
        $rules = Order::$rules;

        $validator = Validator::make($inputs, $rules);
        if ($validator->fails()) {
            $this->setErrors($validator->errors());
            return [$model, false];
        }
        return [$model, true];
    }
}