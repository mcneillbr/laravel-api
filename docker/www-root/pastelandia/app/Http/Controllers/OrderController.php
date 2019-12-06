<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Repositories\OrdemRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = OrdemRepository::getInstance()->all();
        $response = $this->makeJsonResponse($list, 'success', JsonResponse::HTTP_OK);
        return response()->json($response, $response->code);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OrderStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStoreRequest $request)
    {
        $ordem = OrdemRepository::getInstance()->create($this->getInput($request));
        $created = ($ordem && $ordem->id > 0);
        $code = $created ? JsonResponse::HTTP_CREATED : JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        $state = $created ? 'success' : 'fail';
        $response = $this->makeJsonResponse($ordem, $state, $code);
        return response()->json($response, $response->code);
    }

    /**
     * Display the specified resource.
     *
     * @param  object $ordem
     * @return \Illuminate\Http\Response
     */
    public function show($ordem)
    {
        $response = $this->makeJsonResponse($ordem, 'success', JsonResponse::HTTP_OK);
        return response()->json($response, $response->code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OrderUpdateRequest $request
     * @param  object  $ordem
     * @return \Illuminate\Http\Response
     */
    public function update(OrderUpdateRequest $request, $ordem)
    {
        $result = OrdemRepository::getInstance()->update(['id'=> $ordem->id], $this->getInput($request));
        $code = $result > 0 ? JsonResponse::HTTP_OK : JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        $success = $result > 0 ? 'success' : 'fail';
        $optional = ['updated' => $result];
        $response = $this->makeJsonResponse($ordem, $success, $code, $optional);

        return response()->json($response, $response->code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  object $ordem
     * @return \Illuminate\Http\Response
     */
    public function destroy($ordem)
    {
        $result = OrdemRepository::getInstance()->delete(['id'=> $ordem->id]);
        $code = $result > 0 ? JsonResponse::HTTP_OK : JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        $success = $result > 0 ? 'success' : 'fail';
        $optional = ['deleted' => $result];
        $response = $this->makeJsonResponse($ordem, $success, $code, $optional);

        return response()->json($response, $response->code);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getInput(Request $request) {
        return $request->only(['cod_cliente', 'cod_pastel']);
    }
}
