<?php


namespace App\Services;

use App\Repositories\ProductRepository;


class ProductService {
    public function __construct(
        protected ProductRepository $repo
     ) {}

     public function getAll() {
        return $this->repo->all();
     }

     public function store($data) {
        return $this->repo->create($data);
     }
}

?>