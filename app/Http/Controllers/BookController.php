<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookDetailResource;
use Illuminate\Http\JsonResponse;


class BookController extends BaseController
{
    protected $primaryModel = Book::class;
    protected $primaryResource = BookResource::class;
    protected $primaryDetailResource = BookDetailResource::class;
    protected  array $addModFields = ['title', 'price', 'plot', 'published_at', 'collection_id'];

    protected function select(): array
    {
        return ['id', 'title', 'price', 'plot', 'collection_id', 'published_at', 'created_at', 'updated_at'];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return parent::Baseindex();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        return parent::baseShow($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, int $id): JsonResponse
    {
        return parent::baseUpdate($request, $id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return parent::baseDestroy($id);
    }
}
