<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

/**
 * @OA\Schema(
 *     schema="Category",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="code", type="string", example="CAT-001"),
 *     @OA\Property(property="name", type="string", example="Elektronik"),
 *     @OA\Property(property="description", type="string", nullable=true),
 *     @OA\Property(property="is_active", type="boolean", example=true)
 * )
 *
 * @OA\Schema(
 *     schema="Customer",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="code", type="string", example="CUST-001"),
 *     @OA\Property(property="name", type="string", example="PT Maju Jaya"),
 *     @OA\Property(property="email", type="string", format="email", nullable=true),
 *     @OA\Property(property="phone", type="string", nullable=true),
 *     @OA\Property(property="tax_number", type="string", nullable=true),
 *     @OA\Property(property="address", type="string", nullable=true),
 *     @OA\Property(property="is_active", type="boolean", example=true)
 * )
 *
 * @OA\Schema(
 *     schema="Supplier",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="code", type="string", example="SUP-001"),
 *     @OA\Property(property="name", type="string", example="CV Supplier Makmur"),
 *     @OA\Property(property="email", type="string", format="email", nullable=true),
 *     @OA\Property(property="phone", type="string", nullable=true),
 *     @OA\Property(property="contact_person", type="string", nullable=true),
 *     @OA\Property(property="tax_number", type="string", nullable=true),
 *     @OA\Property(property="address", type="string", nullable=true),
 *     @OA\Property(property="is_active", type="boolean", example=true)
 * )
 *
 * @OA\Schema(
 *     schema="Warehouse",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="code", type="string", example="WH-001"),
 *     @OA\Property(property="name", type="string", example="Gudang Pusat"),
 *     @OA\Property(property="address", type="string", nullable=true),
 *     @OA\Property(property="is_active", type="boolean", example=true)
 * )
 *
 * @OA\Schema(
 *     schema="Employee",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="employee_code", type="string", example="EMP-001"),
 *     @OA\Property(property="name", type="string", example="Andi"),
 *     @OA\Property(property="email", type="string", format="email", nullable=true),
 *     @OA\Property(property="phone", type="string", nullable=true),
 *     @OA\Property(property="position", type="string", nullable=true),
 *     @OA\Property(property="hire_date", type="string", format="date", nullable=true),
 *     @OA\Property(property="status", type="string", example="active")
 * )
 *
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="sku", type="string", nullable=true, example="SKU-001"),
 *     @OA\Property(property="category_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="warehouse_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="name", type="string", example="Laptop"),
 *     @OA\Property(property="price", type="number", format="float", example=15000000),
 *     @OA\Property(property="cost_price", type="number", format="float", example=13000000),
 *     @OA\Property(property="unit", type="string", example="pcs"),
 *     @OA\Property(property="stock", type="number", format="float", example=25),
 *     @OA\Property(property="is_active", type="boolean", example=true)
 * )
 *
 * @OA\Get(path="/api/v1/categories", operationId="listCategories", tags={"Categories"}, security={{"bearerAuth":{}}}, summary="Daftar category", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
 * @OA\Post(path="/api/v1/categories", operationId="storeCategory", tags={"Categories"}, security={{"bearerAuth":{}}}, summary="Tambah category", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Category")), @OA\Response(response=201, description="Created"))
 * @OA\Get(path="/api/v1/categories/{id}", operationId="showCategory", tags={"Categories"}, security={{"bearerAuth":{}}}, summary="Detail category", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
 * @OA\Put(path="/api/v1/categories/{id}", operationId="updateCategory", tags={"Categories"}, security={{"bearerAuth":{}}}, summary="Update category", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Category")), @OA\Response(response=200, description="Updated"))
 * @OA\Delete(path="/api/v1/categories/{id}", operationId="deleteCategory", tags={"Categories"}, security={{"bearerAuth":{}}}, summary="Hapus category", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
 *
 * @OA\Get(path="/api/v1/customers", operationId="listCustomers", tags={"Customers"}, security={{"bearerAuth":{}}}, summary="Daftar customer", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
 * @OA\Post(path="/api/v1/customers", operationId="storeCustomer", tags={"Customers"}, security={{"bearerAuth":{}}}, summary="Tambah customer", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Customer")), @OA\Response(response=201, description="Created"))
 * @OA\Get(path="/api/v1/customers/{id}", operationId="showCustomer", tags={"Customers"}, security={{"bearerAuth":{}}}, summary="Detail customer", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
 * @OA\Put(path="/api/v1/customers/{id}", operationId="updateCustomer", tags={"Customers"}, security={{"bearerAuth":{}}}, summary="Update customer", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Customer")), @OA\Response(response=200, description="Updated"))
 * @OA\Delete(path="/api/v1/customers/{id}", operationId="deleteCustomer", tags={"Customers"}, security={{"bearerAuth":{}}}, summary="Hapus customer", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
 *
 * @OA\Get(path="/api/v1/suppliers", operationId="listSuppliers", tags={"Suppliers"}, security={{"bearerAuth":{}}}, summary="Daftar supplier", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
 * @OA\Post(path="/api/v1/suppliers", operationId="storeSupplier", tags={"Suppliers"}, security={{"bearerAuth":{}}}, summary="Tambah supplier", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Supplier")), @OA\Response(response=201, description="Created"))
 * @OA\Get(path="/api/v1/suppliers/{id}", operationId="showSupplier", tags={"Suppliers"}, security={{"bearerAuth":{}}}, summary="Detail supplier", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
 * @OA\Put(path="/api/v1/suppliers/{id}", operationId="updateSupplier", tags={"Suppliers"}, security={{"bearerAuth":{}}}, summary="Update supplier", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Supplier")), @OA\Response(response=200, description="Updated"))
 * @OA\Delete(path="/api/v1/suppliers/{id}", operationId="deleteSupplier", tags={"Suppliers"}, security={{"bearerAuth":{}}}, summary="Hapus supplier", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
 *
 * @OA\Get(path="/api/v1/warehouses", operationId="listWarehouses", tags={"Warehouses"}, security={{"bearerAuth":{}}}, summary="Daftar warehouse", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
 * @OA\Post(path="/api/v1/warehouses", operationId="storeWarehouse", tags={"Warehouses"}, security={{"bearerAuth":{}}}, summary="Tambah warehouse", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Warehouse")), @OA\Response(response=201, description="Created"))
 * @OA\Get(path="/api/v1/warehouses/{id}", operationId="showWarehouse", tags={"Warehouses"}, security={{"bearerAuth":{}}}, summary="Detail warehouse", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
 * @OA\Put(path="/api/v1/warehouses/{id}", operationId="updateWarehouse", tags={"Warehouses"}, security={{"bearerAuth":{}}}, summary="Update warehouse", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Warehouse")), @OA\Response(response=200, description="Updated"))
 * @OA\Delete(path="/api/v1/warehouses/{id}", operationId="deleteWarehouse", tags={"Warehouses"}, security={{"bearerAuth":{}}}, summary="Hapus warehouse", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
 *
 * @OA\Get(path="/api/v1/employees", operationId="listEmployees", tags={"Employees"}, security={{"bearerAuth":{}}}, summary="Daftar employee", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
 * @OA\Post(path="/api/v1/employees", operationId="storeEmployee", tags={"Employees"}, security={{"bearerAuth":{}}}, summary="Tambah employee", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Employee")), @OA\Response(response=201, description="Created"))
 * @OA\Get(path="/api/v1/employees/{id}", operationId="showEmployee", tags={"Employees"}, security={{"bearerAuth":{}}}, summary="Detail employee", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
 * @OA\Put(path="/api/v1/employees/{id}", operationId="updateEmployee", tags={"Employees"}, security={{"bearerAuth":{}}}, summary="Update employee", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Employee")), @OA\Response(response=200, description="Updated"))
 * @OA\Delete(path="/api/v1/employees/{id}", operationId="deleteEmployee", tags={"Employees"}, security={{"bearerAuth":{}}}, summary="Hapus employee", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
 *
 * @OA\Get(path="/api/v1/products", operationId="listProducts", tags={"Products"}, security={{"bearerAuth":{}}}, summary="Daftar product", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
 * @OA\Post(path="/api/v1/products", operationId="storeProduct", tags={"Products"}, security={{"bearerAuth":{}}}, summary="Tambah product", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Product")), @OA\Response(response=201, description="Created"))
 * @OA\Get(path="/api/v1/products/{id}", operationId="showProduct", tags={"Products"}, security={{"bearerAuth":{}}}, summary="Detail product", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
 * @OA\Put(path="/api/v1/products/{id}", operationId="updateProduct", tags={"Products"}, security={{"bearerAuth":{}}}, summary="Update product", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Product")), @OA\Response(response=200, description="Updated"))
 * @OA\Delete(path="/api/v1/products/{id}", operationId="deleteProduct", tags={"Products"}, security={{"bearerAuth":{}}}, summary="Hapus product", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
 */
#[OA\Schema(schema: 'Category', type: 'object', properties: [new OA\Property(property: 'id', type: 'integer', example: 1), new OA\Property(property: 'code', type: 'string', example: 'CAT-001'), new OA\Property(property: 'name', type: 'string', example: 'Elektronik'), new OA\Property(property: 'description', type: 'string', nullable: true), new OA\Property(property: 'is_active', type: 'boolean', example: true)])]
#[OA\Schema(schema: 'Customer', type: 'object', properties: [new OA\Property(property: 'id', type: 'integer', example: 1), new OA\Property(property: 'code', type: 'string', example: 'CUST-001'), new OA\Property(property: 'name', type: 'string', example: 'PT Maju Jaya'), new OA\Property(property: 'email', type: 'string', format: 'email', nullable: true), new OA\Property(property: 'phone', type: 'string', nullable: true), new OA\Property(property: 'tax_number', type: 'string', nullable: true), new OA\Property(property: 'address', type: 'string', nullable: true), new OA\Property(property: 'is_active', type: 'boolean', example: true)])]
#[OA\Schema(schema: 'Supplier', type: 'object', properties: [new OA\Property(property: 'id', type: 'integer', example: 1), new OA\Property(property: 'code', type: 'string', example: 'SUP-001'), new OA\Property(property: 'name', type: 'string', example: 'CV Supplier Makmur'), new OA\Property(property: 'email', type: 'string', format: 'email', nullable: true), new OA\Property(property: 'phone', type: 'string', nullable: true), new OA\Property(property: 'contact_person', type: 'string', nullable: true), new OA\Property(property: 'tax_number', type: 'string', nullable: true), new OA\Property(property: 'address', type: 'string', nullable: true), new OA\Property(property: 'is_active', type: 'boolean', example: true)])]
#[OA\Schema(schema: 'Warehouse', type: 'object', properties: [new OA\Property(property: 'id', type: 'integer', example: 1), new OA\Property(property: 'code', type: 'string', example: 'WH-001'), new OA\Property(property: 'name', type: 'string', example: 'Gudang Pusat'), new OA\Property(property: 'address', type: 'string', nullable: true), new OA\Property(property: 'is_active', type: 'boolean', example: true)])]
#[OA\Schema(schema: 'Employee', type: 'object', properties: [new OA\Property(property: 'id', type: 'integer', example: 1), new OA\Property(property: 'employee_code', type: 'string', example: 'EMP-001'), new OA\Property(property: 'name', type: 'string', example: 'Andi'), new OA\Property(property: 'email', type: 'string', format: 'email', nullable: true), new OA\Property(property: 'phone', type: 'string', nullable: true), new OA\Property(property: 'position', type: 'string', nullable: true), new OA\Property(property: 'hire_date', type: 'string', format: 'date', nullable: true), new OA\Property(property: 'status', type: 'string', example: 'active')])]
#[OA\Schema(schema: 'Product', type: 'object', properties: [new OA\Property(property: 'id', type: 'integer', example: 1), new OA\Property(property: 'sku', type: 'string', nullable: true, example: 'SKU-001'), new OA\Property(property: 'category_id', type: 'integer', nullable: true, example: 1), new OA\Property(property: 'warehouse_id', type: 'integer', nullable: true, example: 1), new OA\Property(property: 'name', type: 'string', example: 'Laptop'), new OA\Property(property: 'price', type: 'number', format: 'float', example: 15000000), new OA\Property(property: 'cost_price', type: 'number', format: 'float', example: 13000000), new OA\Property(property: 'unit', type: 'string', example: 'pcs'), new OA\Property(property: 'stock', type: 'number', format: 'float', example: 25), new OA\Property(property: 'is_active', type: 'boolean', example: true)])]
class MasterDataDocumentation
{
    /**
     * @OA\PathItem(path="/api/v1/categories")
     * @OA\Get(path="/api/v1/categories", operationId="listCategories", tags={"Categories"}, security={{"bearerAuth":{}}}, summary="Daftar category", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
     * @OA\Post(path="/api/v1/categories", operationId="storeCategory", tags={"Categories"}, security={{"bearerAuth":{}}}, summary="Tambah category", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Category")), @OA\Response(response=201, description="Created"))
     */
    public function categories(): void
    {
    }

    #[OA\Get(path: '/api/v1/categories', operationId: 'listCategories', tags: ['Categories'], security: [['bearerAuth' => []]], summary: 'Daftar category', parameters: [new OA\Parameter(ref: '#/components/parameters/PerPage')], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Post(path: '/api/v1/categories', operationId: 'storeCategory', tags: ['Categories'], security: [['bearerAuth' => []]], summary: 'Tambah category', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/Category')), responses: [new OA\Response(response: 201, description: 'Created')])]
    public function categoriesAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/categories/{id}")
     * @OA\Get(path="/api/v1/categories/{id}", operationId="showCategory", tags={"Categories"}, security={{"bearerAuth":{}}}, summary="Detail category", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
     * @OA\Put(path="/api/v1/categories/{id}", operationId="updateCategory", tags={"Categories"}, security={{"bearerAuth":{}}}, summary="Update category", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Category")), @OA\Response(response=200, description="Updated"))
     * @OA\Delete(path="/api/v1/categories/{id}", operationId="deleteCategory", tags={"Categories"}, security={{"bearerAuth":{}}}, summary="Hapus category", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
     */
    public function categoryDetail(): void
    {
    }

    #[OA\Get(path: '/api/v1/categories/{id}', operationId: 'showCategory', tags: ['Categories'], security: [['bearerAuth' => []]], summary: 'Detail category', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Put(path: '/api/v1/categories/{id}', operationId: 'updateCategory', tags: ['Categories'], security: [['bearerAuth' => []]], summary: 'Update category', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/Category')), responses: [new OA\Response(response: 200, description: 'Updated')])]
    #[OA\Delete(path: '/api/v1/categories/{id}', operationId: 'deleteCategory', tags: ['Categories'], security: [['bearerAuth' => []]], summary: 'Hapus category', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Deleted')])]
    public function categoryDetailAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/customers")
     * @OA\Get(path="/api/v1/customers", operationId="listCustomers", tags={"Customers"}, security={{"bearerAuth":{}}}, summary="Daftar customer", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
     * @OA\Post(path="/api/v1/customers", operationId="storeCustomer", tags={"Customers"}, security={{"bearerAuth":{}}}, summary="Tambah customer", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Customer")), @OA\Response(response=201, description="Created"))
     */
    public function customers(): void
    {
    }

    #[OA\Get(path: '/api/v1/customers', operationId: 'listCustomers', tags: ['Customers'], security: [['bearerAuth' => []]], summary: 'Daftar customer', parameters: [new OA\Parameter(ref: '#/components/parameters/PerPage')], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Post(path: '/api/v1/customers', operationId: 'storeCustomer', tags: ['Customers'], security: [['bearerAuth' => []]], summary: 'Tambah customer', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/Customer')), responses: [new OA\Response(response: 201, description: 'Created')])]
    public function customersAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/customers/{id}")
     * @OA\Get(path="/api/v1/customers/{id}", operationId="showCustomer", tags={"Customers"}, security={{"bearerAuth":{}}}, summary="Detail customer", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
     * @OA\Put(path="/api/v1/customers/{id}", operationId="updateCustomer", tags={"Customers"}, security={{"bearerAuth":{}}}, summary="Update customer", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Customer")), @OA\Response(response=200, description="Updated"))
     * @OA\Delete(path="/api/v1/customers/{id}", operationId="deleteCustomer", tags={"Customers"}, security={{"bearerAuth":{}}}, summary="Hapus customer", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
     */
    public function customerDetail(): void
    {
    }

    #[OA\Get(path: '/api/v1/customers/{id}', operationId: 'showCustomer', tags: ['Customers'], security: [['bearerAuth' => []]], summary: 'Detail customer', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Put(path: '/api/v1/customers/{id}', operationId: 'updateCustomer', tags: ['Customers'], security: [['bearerAuth' => []]], summary: 'Update customer', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/Customer')), responses: [new OA\Response(response: 200, description: 'Updated')])]
    #[OA\Delete(path: '/api/v1/customers/{id}', operationId: 'deleteCustomer', tags: ['Customers'], security: [['bearerAuth' => []]], summary: 'Hapus customer', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Deleted')])]
    public function customerDetailAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/suppliers")
     * @OA\Get(path="/api/v1/suppliers", operationId="listSuppliers", tags={"Suppliers"}, security={{"bearerAuth":{}}}, summary="Daftar supplier", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
     * @OA\Post(path="/api/v1/suppliers", operationId="storeSupplier", tags={"Suppliers"}, security={{"bearerAuth":{}}}, summary="Tambah supplier", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Supplier")), @OA\Response(response=201, description="Created"))
     */
    public function suppliers(): void
    {
    }

    #[OA\Get(path: '/api/v1/suppliers', operationId: 'listSuppliers', tags: ['Suppliers'], security: [['bearerAuth' => []]], summary: 'Daftar supplier', parameters: [new OA\Parameter(ref: '#/components/parameters/PerPage')], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Post(path: '/api/v1/suppliers', operationId: 'storeSupplier', tags: ['Suppliers'], security: [['bearerAuth' => []]], summary: 'Tambah supplier', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/Supplier')), responses: [new OA\Response(response: 201, description: 'Created')])]
    public function suppliersAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/suppliers/{id}")
     * @OA\Get(path="/api/v1/suppliers/{id}", operationId="showSupplier", tags={"Suppliers"}, security={{"bearerAuth":{}}}, summary="Detail supplier", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
     * @OA\Put(path="/api/v1/suppliers/{id}", operationId="updateSupplier", tags={"Suppliers"}, security={{"bearerAuth":{}}}, summary="Update supplier", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Supplier")), @OA\Response(response=200, description="Updated"))
     * @OA\Delete(path="/api/v1/suppliers/{id}", operationId="deleteSupplier", tags={"Suppliers"}, security={{"bearerAuth":{}}}, summary="Hapus supplier", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
     */
    public function supplierDetail(): void
    {
    }

    #[OA\Get(path: '/api/v1/suppliers/{id}', operationId: 'showSupplier', tags: ['Suppliers'], security: [['bearerAuth' => []]], summary: 'Detail supplier', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Put(path: '/api/v1/suppliers/{id}', operationId: 'updateSupplier', tags: ['Suppliers'], security: [['bearerAuth' => []]], summary: 'Update supplier', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/Supplier')), responses: [new OA\Response(response: 200, description: 'Updated')])]
    #[OA\Delete(path: '/api/v1/suppliers/{id}', operationId: 'deleteSupplier', tags: ['Suppliers'], security: [['bearerAuth' => []]], summary: 'Hapus supplier', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Deleted')])]
    public function supplierDetailAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/warehouses")
     * @OA\Get(path="/api/v1/warehouses", operationId="listWarehouses", tags={"Warehouses"}, security={{"bearerAuth":{}}}, summary="Daftar warehouse", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
     * @OA\Post(path="/api/v1/warehouses", operationId="storeWarehouse", tags={"Warehouses"}, security={{"bearerAuth":{}}}, summary="Tambah warehouse", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Warehouse")), @OA\Response(response=201, description="Created"))
     */
    public function warehouses(): void
    {
    }

    #[OA\Get(path: '/api/v1/warehouses', operationId: 'listWarehouses', tags: ['Warehouses'], security: [['bearerAuth' => []]], summary: 'Daftar warehouse', parameters: [new OA\Parameter(ref: '#/components/parameters/PerPage')], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Post(path: '/api/v1/warehouses', operationId: 'storeWarehouse', tags: ['Warehouses'], security: [['bearerAuth' => []]], summary: 'Tambah warehouse', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/Warehouse')), responses: [new OA\Response(response: 201, description: 'Created')])]
    public function warehousesAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/warehouses/{id}")
     * @OA\Get(path="/api/v1/warehouses/{id}", operationId="showWarehouse", tags={"Warehouses"}, security={{"bearerAuth":{}}}, summary="Detail warehouse", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
     * @OA\Put(path="/api/v1/warehouses/{id}", operationId="updateWarehouse", tags={"Warehouses"}, security={{"bearerAuth":{}}}, summary="Update warehouse", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Warehouse")), @OA\Response(response=200, description="Updated"))
     * @OA\Delete(path="/api/v1/warehouses/{id}", operationId="deleteWarehouse", tags={"Warehouses"}, security={{"bearerAuth":{}}}, summary="Hapus warehouse", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
     */
    public function warehouseDetail(): void
    {
    }

    #[OA\Get(path: '/api/v1/warehouses/{id}', operationId: 'showWarehouse', tags: ['Warehouses'], security: [['bearerAuth' => []]], summary: 'Detail warehouse', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Put(path: '/api/v1/warehouses/{id}', operationId: 'updateWarehouse', tags: ['Warehouses'], security: [['bearerAuth' => []]], summary: 'Update warehouse', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/Warehouse')), responses: [new OA\Response(response: 200, description: 'Updated')])]
    #[OA\Delete(path: '/api/v1/warehouses/{id}', operationId: 'deleteWarehouse', tags: ['Warehouses'], security: [['bearerAuth' => []]], summary: 'Hapus warehouse', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Deleted')])]
    public function warehouseDetailAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/employees")
     * @OA\Get(path="/api/v1/employees", operationId="listEmployees", tags={"Employees"}, security={{"bearerAuth":{}}}, summary="Daftar employee", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
     * @OA\Post(path="/api/v1/employees", operationId="storeEmployee", tags={"Employees"}, security={{"bearerAuth":{}}}, summary="Tambah employee", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Employee")), @OA\Response(response=201, description="Created"))
     */
    public function employees(): void
    {
    }

    #[OA\Get(path: '/api/v1/employees', operationId: 'listEmployees', tags: ['Employees'], security: [['bearerAuth' => []]], summary: 'Daftar employee', parameters: [new OA\Parameter(ref: '#/components/parameters/PerPage')], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Post(path: '/api/v1/employees', operationId: 'storeEmployee', tags: ['Employees'], security: [['bearerAuth' => []]], summary: 'Tambah employee', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/Employee')), responses: [new OA\Response(response: 201, description: 'Created')])]
    public function employeesAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/employees/{id}")
     * @OA\Get(path="/api/v1/employees/{id}", operationId="showEmployee", tags={"Employees"}, security={{"bearerAuth":{}}}, summary="Detail employee", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
     * @OA\Put(path="/api/v1/employees/{id}", operationId="updateEmployee", tags={"Employees"}, security={{"bearerAuth":{}}}, summary="Update employee", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Employee")), @OA\Response(response=200, description="Updated"))
     * @OA\Delete(path="/api/v1/employees/{id}", operationId="deleteEmployee", tags={"Employees"}, security={{"bearerAuth":{}}}, summary="Hapus employee", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
     */
    public function employeeDetail(): void
    {
    }

    #[OA\Get(path: '/api/v1/employees/{id}', operationId: 'showEmployee', tags: ['Employees'], security: [['bearerAuth' => []]], summary: 'Detail employee', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Put(path: '/api/v1/employees/{id}', operationId: 'updateEmployee', tags: ['Employees'], security: [['bearerAuth' => []]], summary: 'Update employee', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/Employee')), responses: [new OA\Response(response: 200, description: 'Updated')])]
    #[OA\Delete(path: '/api/v1/employees/{id}', operationId: 'deleteEmployee', tags: ['Employees'], security: [['bearerAuth' => []]], summary: 'Hapus employee', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Deleted')])]
    public function employeeDetailAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/products")
     * @OA\Get(path="/api/v1/products", operationId="listProducts", tags={"Products"}, security={{"bearerAuth":{}}}, summary="Daftar product", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
     * @OA\Post(path="/api/v1/products", operationId="storeProduct", tags={"Products"}, security={{"bearerAuth":{}}}, summary="Tambah product", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Product")), @OA\Response(response=201, description="Created"))
     */
    public function products(): void
    {
    }

    #[OA\Get(path: '/api/v1/products', operationId: 'listProducts', tags: ['Products'], security: [['bearerAuth' => []]], summary: 'Daftar product', parameters: [new OA\Parameter(ref: '#/components/parameters/PerPage')], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Post(path: '/api/v1/products', operationId: 'storeProduct', tags: ['Products'], security: [['bearerAuth' => []]], summary: 'Tambah product', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/Product')), responses: [new OA\Response(response: 201, description: 'Created')])]
    public function productsAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/products/{id}")
     * @OA\Get(path="/api/v1/products/{id}", operationId="showProduct", tags={"Products"}, security={{"bearerAuth":{}}}, summary="Detail product", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
     * @OA\Put(path="/api/v1/products/{id}", operationId="updateProduct", tags={"Products"}, security={{"bearerAuth":{}}}, summary="Update product", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/Product")), @OA\Response(response=200, description="Updated"))
     * @OA\Delete(path="/api/v1/products/{id}", operationId="deleteProduct", tags={"Products"}, security={{"bearerAuth":{}}}, summary="Hapus product", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
     */
    public function productDetail(): void
    {
    }

    #[OA\Get(path: '/api/v1/products/{id}', operationId: 'showProduct', tags: ['Products'], security: [['bearerAuth' => []]], summary: 'Detail product', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Put(path: '/api/v1/products/{id}', operationId: 'updateProduct', tags: ['Products'], security: [['bearerAuth' => []]], summary: 'Update product', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/Product')), responses: [new OA\Response(response: 200, description: 'Updated')])]
    #[OA\Delete(path: '/api/v1/products/{id}', operationId: 'deleteProduct', tags: ['Products'], security: [['bearerAuth' => []]], summary: 'Hapus product', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Deleted')])]
    public function productDetailAttr(): void
    {
    }
}
