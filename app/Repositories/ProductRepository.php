<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository {
    public function all() {
        return Product::latest()->paginate(10);
    }

    public function create($data) {
        return Product::create($data);
    }
}

?>