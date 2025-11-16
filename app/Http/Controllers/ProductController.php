<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $repo;
    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return response()->json($this->repo->all());
    }

    public function store(Request $request)
    {
        $product = $this->repo->create($request->all());
        return response()->json($product, 201);
    }

    public function show($id)
    {
        return response()->json($this->repo->find($id));
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->repo->update($id, $request->all()));
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return response()->json(['message' => 'Deleted']);
    }
}
