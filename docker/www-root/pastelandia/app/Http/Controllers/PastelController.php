<?php

namespace App\Http\Controllers;

use App\Http\Requests\PastelStoreRequest;
use App\Http\Requests\PastelUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\PastelRepository;
use Illuminate\Http\Response;

class PastelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $listPastel = PastelRepository::getInstance()->all();
        $response = $this->makeJsonResponse($listPastel, 'success', JsonResponse::HTTP_OK);
        return response()->json($response, $response->code);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(PastelStoreRequest $request)
    {
        $pastel = PastelRepository::getInstance()->create($this->getInput($request));
        $created = ($pastel && $pastel->id > 0);
        $code = $created ? JsonResponse::HTTP_CREATED : JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        $state = $created ? 'success' : 'fail';
        $response = $this->makeJsonResponse($pastel, $state, $code);
        return response()->json($response, $response->code);
    }

    /**
     * Display the specified resource.
     *
     * @param  object $pastel
     * @return Response
     */
    public function show($pastel)
    {
        $response = $this->makeJsonResponse($pastel, 'success', JsonResponse::HTTP_OK);
        return response()->json($response, $response->code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PastelUpdateRequest $request
     * @param  object $pastel
     * @return Response
     */
    public function update(PastelUpdateRequest $request, $pastel)
    {

        $result = PastelRepository::getInstance()->update(['id'=> $pastel->id], $this->getInput($request));
        $code = $result > 0 ? JsonResponse::HTTP_OK : JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        $success = $result > 0 ? 'success' : 'fail';
        $optional = ['updated' => $result];
        $response = $this->makeJsonResponse($pastel, $success, $code, $optional);

        return response()->json($response, $response->code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  object $pastel
     * @return Response
     */
    public function destroy($pastel)
    {
        $result = PastelRepository::getInstance()->delete(['id'=> $pastel->id]);
        $code = $result > 0 ? JsonResponse::HTTP_OK : JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        $success = $result > 0 ? 'success' : 'fail';
        $optional = ['deleted' => $result];
        $response = $this->makeJsonResponse($pastel, $success, $code, $optional);

        return response()->json($response, $response->code);
    }


    /**
     * @param Request $request
     * @return array
     */
    private function getInput(Request $request) {
        return $request->only(['nome', 'preco', 'foto']);
    }
}
