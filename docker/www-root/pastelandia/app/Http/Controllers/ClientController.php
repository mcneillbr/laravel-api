<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\ClientRepository;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients =  ClientRepository::getInstance()->all();
        $response = $this->makeJsonResponse($clients, 'success', JsonResponse::HTTP_OK);
        return response()->json($response, $response->code);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClientStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientStoreRequest $request)
    {
        $client = ClientRepository::getInstance()->create($this->getInput($request));
        $created = ($client && $client->id > 0);
        $code = $created ? JsonResponse::HTTP_CREATED : JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        $state = $created ? 'success' : 'fail';
        $response = $this->makeJsonResponse($client, $state, $code);
        return response()->json($response, $response->code);

    }

    /**
     * Display the specified resource.
     *
     * @param object $client
     * @return \Illuminate\Http\Response
     */
    public function show($client)
    {
        $response = $this->makeJsonResponse($client, 'success', JsonResponse::HTTP_OK);
        return response()->json($response, $response->code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param object $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientUpdateRequest $request, $client)
    {
        $repository = ClientRepository::getInstance();
        $result = $repository->update(['id'=> $client->id], $this->getInput($request));
        $code = $result > 0 ? JsonResponse::HTTP_OK : JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        $success = $result > 0 ? 'success' : 'fail';
        $optional = ['updated' => $result];
        $response = $this->makeJsonResponse($client, $success, $code, $optional);

        return response()->json($response, $response->code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param object $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($client)
    {

        $repository = ClientRepository::getInstance();
        $result = $repository->delete(['id'=> $client->id]);
        $code = $result > 0 ? JsonResponse::HTTP_OK : JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        $success = $result > 0 ? 'success' : 'fail';
        $optional = ['deleted' => $result];
        $response = $this->makeJsonResponse($client, $success, $code, $optional);

        return response()->json($response, $response->code);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getInput(Request $request) {
        return $request->only('nome', 'email', 'telefone', 'data_nascimento', 'endereco', 'bairro', 'cep');
    }
}
