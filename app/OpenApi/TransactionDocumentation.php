<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

/**
 * @OA\Schema(
 *     schema="PurchaseOrderItemInput",
 *     type="object",
 *     required={"product_id","qty","price"},
 *     @OA\Property(property="product_id", type="integer", example=1),
 *     @OA\Property(property="qty", type="number", format="float", example=10),
 *     @OA\Property(property="price", type="number", format="float", example=12500000)
 * )
 *
 * @OA\Schema(
 *     schema="SalesOrderItemInput",
 *     type="object",
 *     required={"product_id","qty","price"},
 *     @OA\Property(property="product_id", type="integer", example=1),
 *     @OA\Property(property="qty", type="number", format="float", example=2),
 *     @OA\Property(property="price", type="number", format="float", example=15000000)
 * )
 *
 * @OA\Schema(
 *     schema="PurchaseOrderRequest",
 *     type="object",
 *     required={"supplier_id","order_date","items"},
 *     @OA\Property(property="po_number", type="string", nullable=true),
 *     @OA\Property(property="supplier_id", type="integer", example=1),
 *     @OA\Property(property="order_date", type="string", format="date", example="2026-03-24"),
 *     @OA\Property(property="status", type="string", example="draft"),
 *     @OA\Property(property="tax", type="number", format="float", example=1100000),
 *     @OA\Property(property="notes", type="string", nullable=true),
 *     @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/PurchaseOrderItemInput"))
 * )
 *
 * @OA\Schema(
 *     schema="SalesOrderRequest",
 *     type="object",
 *     required={"customer_id","order_date","items"},
 *     @OA\Property(property="so_number", type="string", nullable=true),
 *     @OA\Property(property="customer_id", type="integer", example=1),
 *     @OA\Property(property="order_date", type="string", format="date", example="2026-03-24"),
 *     @OA\Property(property="status", type="string", example="draft"),
 *     @OA\Property(property="tax", type="number", format="float", example=550000),
 *     @OA\Property(property="notes", type="string", nullable=true),
 *     @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/SalesOrderItemInput"))
 * )
 *
 * @OA\Schema(
 *     schema="InvoiceRequest",
 *     type="object",
 *     required={"customer_id","invoice_date"},
 *     @OA\Property(property="invoice_number", type="string", nullable=true),
 *     @OA\Property(property="sales_order_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="customer_id", type="integer", example=1),
 *     @OA\Property(property="invoice_date", type="string", format="date", example="2026-03-24"),
 *     @OA\Property(property="due_date", type="string", format="date", nullable=true, example="2026-04-24"),
 *     @OA\Property(property="status", type="string", example="unpaid"),
 *     @OA\Property(property="subtotal", type="number", format="float", example=30000000),
 *     @OA\Property(property="tax", type="number", format="float", example=3300000),
 *     @OA\Property(property="notes", type="string", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="PaymentRequest",
 *     type="object",
 *     required={"invoice_id","payment_date","method","amount"},
 *     @OA\Property(property="payment_number", type="string", nullable=true),
 *     @OA\Property(property="invoice_id", type="integer", example=1),
 *     @OA\Property(property="payment_date", type="string", format="date", example="2026-03-24"),
 *     @OA\Property(property="method", type="string", example="bank_transfer"),
 *     @OA\Property(property="amount", type="number", format="float", example=10000000),
 *     @OA\Property(property="reference_no", type="string", nullable=true),
 *     @OA\Property(property="notes", type="string", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="StockMovementRequest",
 *     type="object",
 *     required={"product_id","type","quantity"},
 *     @OA\Property(property="movement_number", type="string", nullable=true),
 *     @OA\Property(property="product_id", type="integer", example=1),
 *     @OA\Property(property="warehouse_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="type", type="string", example="in"),
 *     @OA\Property(property="quantity", type="number", format="float", example=5),
 *     @OA\Property(property="reference_type", type="string", nullable=true),
 *     @OA\Property(property="reference_id", type="integer", nullable=true),
 *     @OA\Property(property="notes", type="string", nullable=true),
 *     @OA\Property(property="moved_at", type="string", format="date-time", nullable=true)
 * )
 *
 * @OA\Get(
 *     path="/api/v1/dashboard",
 *     operationId="getDashboard",
 *     tags={"Dashboard"},
 *     security={{"bearerAuth":{}}},
 *     summary="Ambil statistik dashboard ERP",
 *     @OA\Response(response=200, description="Sukses")
 * )
 *
 * @OA\Get(path="/api/v1/purchase-orders", operationId="listPurchaseOrders", tags={"Purchase Orders"}, security={{"bearerAuth":{}}}, summary="Daftar purchase order", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
 * @OA\Post(path="/api/v1/purchase-orders", operationId="storePurchaseOrder", tags={"Purchase Orders"}, security={{"bearerAuth":{}}}, summary="Tambah purchase order", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/PurchaseOrderRequest")), @OA\Response(response=201, description="Created"))
 * @OA\Get(path="/api/v1/purchase-orders/{id}", operationId="showPurchaseOrder", tags={"Purchase Orders"}, security={{"bearerAuth":{}}}, summary="Detail purchase order", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
 * @OA\Put(path="/api/v1/purchase-orders/{id}", operationId="updatePurchaseOrder", tags={"Purchase Orders"}, security={{"bearerAuth":{}}}, summary="Update purchase order", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/PurchaseOrderRequest")), @OA\Response(response=200, description="Updated"))
 * @OA\Delete(path="/api/v1/purchase-orders/{id}", operationId="deletePurchaseOrder", tags={"Purchase Orders"}, security={{"bearerAuth":{}}}, summary="Hapus purchase order", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
 *
 * @OA\Get(path="/api/v1/sales-orders", operationId="listSalesOrders", tags={"Sales Orders"}, security={{"bearerAuth":{}}}, summary="Daftar sales order", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
 * @OA\Post(path="/api/v1/sales-orders", operationId="storeSalesOrder", tags={"Sales Orders"}, security={{"bearerAuth":{}}}, summary="Tambah sales order", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/SalesOrderRequest")), @OA\Response(response=201, description="Created"))
 * @OA\Get(path="/api/v1/sales-orders/{id}", operationId="showSalesOrder", tags={"Sales Orders"}, security={{"bearerAuth":{}}}, summary="Detail sales order", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
 * @OA\Put(path="/api/v1/sales-orders/{id}", operationId="updateSalesOrder", tags={"Sales Orders"}, security={{"bearerAuth":{}}}, summary="Update sales order", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/SalesOrderRequest")), @OA\Response(response=200, description="Updated"))
 * @OA\Delete(path="/api/v1/sales-orders/{id}", operationId="deleteSalesOrder", tags={"Sales Orders"}, security={{"bearerAuth":{}}}, summary="Hapus sales order", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
 *
 * @OA\Get(path="/api/v1/invoices", operationId="listInvoices", tags={"Invoices"}, security={{"bearerAuth":{}}}, summary="Daftar invoice", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
 * @OA\Post(path="/api/v1/invoices", operationId="storeInvoice", tags={"Invoices"}, security={{"bearerAuth":{}}}, summary="Tambah invoice", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/InvoiceRequest")), @OA\Response(response=201, description="Created"))
 * @OA\Get(path="/api/v1/invoices/{id}", operationId="showInvoice", tags={"Invoices"}, security={{"bearerAuth":{}}}, summary="Detail invoice", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
 * @OA\Put(path="/api/v1/invoices/{id}", operationId="updateInvoice", tags={"Invoices"}, security={{"bearerAuth":{}}}, summary="Update invoice", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/InvoiceRequest")), @OA\Response(response=200, description="Updated"))
 * @OA\Delete(path="/api/v1/invoices/{id}", operationId="deleteInvoice", tags={"Invoices"}, security={{"bearerAuth":{}}}, summary="Hapus invoice", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
 *
 * @OA\Get(path="/api/v1/payments", operationId="listPayments", tags={"Payments"}, security={{"bearerAuth":{}}}, summary="Daftar payment", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
 * @OA\Post(path="/api/v1/payments", operationId="storePayment", tags={"Payments"}, security={{"bearerAuth":{}}}, summary="Tambah payment", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/PaymentRequest")), @OA\Response(response=201, description="Created"))
 * @OA\Get(path="/api/v1/payments/{id}", operationId="showPayment", tags={"Payments"}, security={{"bearerAuth":{}}}, summary="Detail payment", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
 * @OA\Put(path="/api/v1/payments/{id}", operationId="updatePayment", tags={"Payments"}, security={{"bearerAuth":{}}}, summary="Update payment", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/PaymentRequest")), @OA\Response(response=200, description="Updated"))
 * @OA\Delete(path="/api/v1/payments/{id}", operationId="deletePayment", tags={"Payments"}, security={{"bearerAuth":{}}}, summary="Hapus payment", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
 *
 * @OA\Get(path="/api/v1/stock-movements", operationId="listStockMovements", tags={"Stock Movements"}, security={{"bearerAuth":{}}}, summary="Daftar stock movement", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
 * @OA\Post(path="/api/v1/stock-movements", operationId="storeStockMovement", tags={"Stock Movements"}, security={{"bearerAuth":{}}}, summary="Tambah stock movement", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StockMovementRequest")), @OA\Response(response=201, description="Created"))
 * @OA\Get(path="/api/v1/stock-movements/{id}", operationId="showStockMovement", tags={"Stock Movements"}, security={{"bearerAuth":{}}}, summary="Detail stock movement", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
 * @OA\Put(path="/api/v1/stock-movements/{id}", operationId="updateStockMovement", tags={"Stock Movements"}, security={{"bearerAuth":{}}}, summary="Update stock movement", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StockMovementRequest")), @OA\Response(response=200, description="Updated"))
 */
#[OA\Schema(schema: 'PurchaseOrderItemInput', type: 'object', required: ['product_id', 'qty', 'price'], properties: [new OA\Property(property: 'product_id', type: 'integer', example: 1), new OA\Property(property: 'qty', type: 'number', format: 'float', example: 10), new OA\Property(property: 'price', type: 'number', format: 'float', example: 12500000)])]
#[OA\Schema(schema: 'SalesOrderItemInput', type: 'object', required: ['product_id', 'qty', 'price'], properties: [new OA\Property(property: 'product_id', type: 'integer', example: 1), new OA\Property(property: 'qty', type: 'number', format: 'float', example: 2), new OA\Property(property: 'price', type: 'number', format: 'float', example: 15000000)])]
#[OA\Schema(schema: 'PurchaseOrderRequest', type: 'object', required: ['supplier_id', 'order_date', 'items'], properties: [new OA\Property(property: 'po_number', type: 'string', nullable: true), new OA\Property(property: 'supplier_id', type: 'integer', example: 1), new OA\Property(property: 'order_date', type: 'string', format: 'date', example: '2026-03-24'), new OA\Property(property: 'status', type: 'string', example: 'draft'), new OA\Property(property: 'tax', type: 'number', format: 'float', example: 1100000), new OA\Property(property: 'notes', type: 'string', nullable: true), new OA\Property(property: 'items', type: 'array', items: new OA\Items(ref: '#/components/schemas/PurchaseOrderItemInput'))])]
#[OA\Schema(schema: 'SalesOrderRequest', type: 'object', required: ['customer_id', 'order_date', 'items'], properties: [new OA\Property(property: 'so_number', type: 'string', nullable: true), new OA\Property(property: 'customer_id', type: 'integer', example: 1), new OA\Property(property: 'order_date', type: 'string', format: 'date', example: '2026-03-24'), new OA\Property(property: 'status', type: 'string', example: 'draft'), new OA\Property(property: 'tax', type: 'number', format: 'float', example: 550000), new OA\Property(property: 'notes', type: 'string', nullable: true), new OA\Property(property: 'items', type: 'array', items: new OA\Items(ref: '#/components/schemas/SalesOrderItemInput'))])]
#[OA\Schema(schema: 'InvoiceRequest', type: 'object', required: ['customer_id', 'invoice_date'], properties: [new OA\Property(property: 'invoice_number', type: 'string', nullable: true), new OA\Property(property: 'sales_order_id', type: 'integer', nullable: true, example: 1), new OA\Property(property: 'customer_id', type: 'integer', example: 1), new OA\Property(property: 'invoice_date', type: 'string', format: 'date', example: '2026-03-24'), new OA\Property(property: 'due_date', type: 'string', format: 'date', nullable: true, example: '2026-04-24'), new OA\Property(property: 'status', type: 'string', example: 'unpaid'), new OA\Property(property: 'subtotal', type: 'number', format: 'float', example: 30000000), new OA\Property(property: 'tax', type: 'number', format: 'float', example: 3300000), new OA\Property(property: 'notes', type: 'string', nullable: true)])]
#[OA\Schema(schema: 'PaymentRequest', type: 'object', required: ['invoice_id', 'payment_date', 'method', 'amount'], properties: [new OA\Property(property: 'payment_number', type: 'string', nullable: true), new OA\Property(property: 'invoice_id', type: 'integer', example: 1), new OA\Property(property: 'payment_date', type: 'string', format: 'date', example: '2026-03-24'), new OA\Property(property: 'method', type: 'string', example: 'bank_transfer'), new OA\Property(property: 'amount', type: 'number', format: 'float', example: 10000000), new OA\Property(property: 'reference_no', type: 'string', nullable: true), new OA\Property(property: 'notes', type: 'string', nullable: true)])]
#[OA\Schema(schema: 'StockMovementRequest', type: 'object', required: ['product_id', 'type', 'quantity'], properties: [new OA\Property(property: 'movement_number', type: 'string', nullable: true), new OA\Property(property: 'product_id', type: 'integer', example: 1), new OA\Property(property: 'warehouse_id', type: 'integer', nullable: true, example: 1), new OA\Property(property: 'type', type: 'string', example: 'in'), new OA\Property(property: 'quantity', type: 'number', format: 'float', example: 5), new OA\Property(property: 'reference_type', type: 'string', nullable: true), new OA\Property(property: 'reference_id', type: 'integer', nullable: true), new OA\Property(property: 'notes', type: 'string', nullable: true), new OA\Property(property: 'moved_at', type: 'string', format: 'date-time', nullable: true)])]
class TransactionDocumentation
{
    /**
     * @OA\PathItem(path="/api/v1/dashboard")
     * @OA\Get(path="/api/v1/dashboard", operationId="getDashboard", tags={"Dashboard"}, security={{"bearerAuth":{}}}, summary="Ambil statistik dashboard ERP", @OA\Response(response=200, description="Sukses"))
     */
    public function dashboard(): void
    {
    }

    #[OA\Get(path: '/api/v1/dashboard', operationId: 'getDashboard', tags: ['Dashboard'], security: [['bearerAuth' => []]], summary: 'Ambil statistik dashboard ERP', responses: [new OA\Response(response: 200, description: 'Sukses')])]
    public function dashboardAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/purchase-orders")
     * @OA\Get(path="/api/v1/purchase-orders", operationId="listPurchaseOrders", tags={"Purchase Orders"}, security={{"bearerAuth":{}}}, summary="Daftar purchase order", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
     * @OA\Post(path="/api/v1/purchase-orders", operationId="storePurchaseOrder", tags={"Purchase Orders"}, security={{"bearerAuth":{}}}, summary="Tambah purchase order", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/PurchaseOrderRequest")), @OA\Response(response=201, description="Created"))
     */
    public function purchaseOrders(): void
    {
    }

    #[OA\Get(path: '/api/v1/purchase-orders', operationId: 'listPurchaseOrders', tags: ['Purchase Orders'], security: [['bearerAuth' => []]], summary: 'Daftar purchase order', parameters: [new OA\Parameter(ref: '#/components/parameters/PerPage')], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Post(path: '/api/v1/purchase-orders', operationId: 'storePurchaseOrder', tags: ['Purchase Orders'], security: [['bearerAuth' => []]], summary: 'Tambah purchase order', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/PurchaseOrderRequest')), responses: [new OA\Response(response: 201, description: 'Created')])]
    public function purchaseOrdersAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/purchase-orders/{id}")
     * @OA\Get(path="/api/v1/purchase-orders/{id}", operationId="showPurchaseOrder", tags={"Purchase Orders"}, security={{"bearerAuth":{}}}, summary="Detail purchase order", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
     * @OA\Put(path="/api/v1/purchase-orders/{id}", operationId="updatePurchaseOrder", tags={"Purchase Orders"}, security={{"bearerAuth":{}}}, summary="Update purchase order", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/PurchaseOrderRequest")), @OA\Response(response=200, description="Updated"))
     * @OA\Delete(path="/api/v1/purchase-orders/{id}", operationId="deletePurchaseOrder", tags={"Purchase Orders"}, security={{"bearerAuth":{}}}, summary="Hapus purchase order", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
     */
    public function purchaseOrderDetail(): void
    {
    }

    #[OA\Get(path: '/api/v1/purchase-orders/{id}', operationId: 'showPurchaseOrder', tags: ['Purchase Orders'], security: [['bearerAuth' => []]], summary: 'Detail purchase order', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Put(path: '/api/v1/purchase-orders/{id}', operationId: 'updatePurchaseOrder', tags: ['Purchase Orders'], security: [['bearerAuth' => []]], summary: 'Update purchase order', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/PurchaseOrderRequest')), responses: [new OA\Response(response: 200, description: 'Updated')])]
    #[OA\Delete(path: '/api/v1/purchase-orders/{id}', operationId: 'deletePurchaseOrder', tags: ['Purchase Orders'], security: [['bearerAuth' => []]], summary: 'Hapus purchase order', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Deleted')])]
    public function purchaseOrderDetailAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/sales-orders")
     * @OA\Get(path="/api/v1/sales-orders", operationId="listSalesOrders", tags={"Sales Orders"}, security={{"bearerAuth":{}}}, summary="Daftar sales order", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
     * @OA\Post(path="/api/v1/sales-orders", operationId="storeSalesOrder", tags={"Sales Orders"}, security={{"bearerAuth":{}}}, summary="Tambah sales order", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/SalesOrderRequest")), @OA\Response(response=201, description="Created"))
     */
    public function salesOrders(): void
    {
    }

    #[OA\Get(path: '/api/v1/sales-orders', operationId: 'listSalesOrders', tags: ['Sales Orders'], security: [['bearerAuth' => []]], summary: 'Daftar sales order', parameters: [new OA\Parameter(ref: '#/components/parameters/PerPage')], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Post(path: '/api/v1/sales-orders', operationId: 'storeSalesOrder', tags: ['Sales Orders'], security: [['bearerAuth' => []]], summary: 'Tambah sales order', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/SalesOrderRequest')), responses: [new OA\Response(response: 201, description: 'Created')])]
    public function salesOrdersAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/sales-orders/{id}")
     * @OA\Get(path="/api/v1/sales-orders/{id}", operationId="showSalesOrder", tags={"Sales Orders"}, security={{"bearerAuth":{}}}, summary="Detail sales order", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
     * @OA\Put(path="/api/v1/sales-orders/{id}", operationId="updateSalesOrder", tags={"Sales Orders"}, security={{"bearerAuth":{}}}, summary="Update sales order", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/SalesOrderRequest")), @OA\Response(response=200, description="Updated"))
     * @OA\Delete(path="/api/v1/sales-orders/{id}", operationId="deleteSalesOrder", tags={"Sales Orders"}, security={{"bearerAuth":{}}}, summary="Hapus sales order", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
     */
    public function salesOrderDetail(): void
    {
    }

    #[OA\Get(path: '/api/v1/sales-orders/{id}', operationId: 'showSalesOrder', tags: ['Sales Orders'], security: [['bearerAuth' => []]], summary: 'Detail sales order', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Put(path: '/api/v1/sales-orders/{id}', operationId: 'updateSalesOrder', tags: ['Sales Orders'], security: [['bearerAuth' => []]], summary: 'Update sales order', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/SalesOrderRequest')), responses: [new OA\Response(response: 200, description: 'Updated')])]
    #[OA\Delete(path: '/api/v1/sales-orders/{id}', operationId: 'deleteSalesOrder', tags: ['Sales Orders'], security: [['bearerAuth' => []]], summary: 'Hapus sales order', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Deleted')])]
    public function salesOrderDetailAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/invoices")
     * @OA\Get(path="/api/v1/invoices", operationId="listInvoices", tags={"Invoices"}, security={{"bearerAuth":{}}}, summary="Daftar invoice", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
     * @OA\Post(path="/api/v1/invoices", operationId="storeInvoice", tags={"Invoices"}, security={{"bearerAuth":{}}}, summary="Tambah invoice", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/InvoiceRequest")), @OA\Response(response=201, description="Created"))
     */
    public function invoices(): void
    {
    }

    #[OA\Get(path: '/api/v1/invoices', operationId: 'listInvoices', tags: ['Invoices'], security: [['bearerAuth' => []]], summary: 'Daftar invoice', parameters: [new OA\Parameter(ref: '#/components/parameters/PerPage')], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Post(path: '/api/v1/invoices', operationId: 'storeInvoice', tags: ['Invoices'], security: [['bearerAuth' => []]], summary: 'Tambah invoice', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/InvoiceRequest')), responses: [new OA\Response(response: 201, description: 'Created')])]
    public function invoicesAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/invoices/{id}")
     * @OA\Get(path="/api/v1/invoices/{id}", operationId="showInvoice", tags={"Invoices"}, security={{"bearerAuth":{}}}, summary="Detail invoice", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
     * @OA\Put(path="/api/v1/invoices/{id}", operationId="updateInvoice", tags={"Invoices"}, security={{"bearerAuth":{}}}, summary="Update invoice", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/InvoiceRequest")), @OA\Response(response=200, description="Updated"))
     * @OA\Delete(path="/api/v1/invoices/{id}", operationId="deleteInvoice", tags={"Invoices"}, security={{"bearerAuth":{}}}, summary="Hapus invoice", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
     */
    public function invoiceDetail(): void
    {
    }

    #[OA\Get(path: '/api/v1/invoices/{id}', operationId: 'showInvoice', tags: ['Invoices'], security: [['bearerAuth' => []]], summary: 'Detail invoice', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Put(path: '/api/v1/invoices/{id}', operationId: 'updateInvoice', tags: ['Invoices'], security: [['bearerAuth' => []]], summary: 'Update invoice', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/InvoiceRequest')), responses: [new OA\Response(response: 200, description: 'Updated')])]
    #[OA\Delete(path: '/api/v1/invoices/{id}', operationId: 'deleteInvoice', tags: ['Invoices'], security: [['bearerAuth' => []]], summary: 'Hapus invoice', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Deleted')])]
    public function invoiceDetailAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/payments")
     * @OA\Get(path="/api/v1/payments", operationId="listPayments", tags={"Payments"}, security={{"bearerAuth":{}}}, summary="Daftar payment", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
     * @OA\Post(path="/api/v1/payments", operationId="storePayment", tags={"Payments"}, security={{"bearerAuth":{}}}, summary="Tambah payment", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/PaymentRequest")), @OA\Response(response=201, description="Created"))
     */
    public function payments(): void
    {
    }

    #[OA\Get(path: '/api/v1/payments', operationId: 'listPayments', tags: ['Payments'], security: [['bearerAuth' => []]], summary: 'Daftar payment', parameters: [new OA\Parameter(ref: '#/components/parameters/PerPage')], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Post(path: '/api/v1/payments', operationId: 'storePayment', tags: ['Payments'], security: [['bearerAuth' => []]], summary: 'Tambah payment', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/PaymentRequest')), responses: [new OA\Response(response: 201, description: 'Created')])]
    public function paymentsAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/payments/{id}")
     * @OA\Get(path="/api/v1/payments/{id}", operationId="showPayment", tags={"Payments"}, security={{"bearerAuth":{}}}, summary="Detail payment", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
     * @OA\Put(path="/api/v1/payments/{id}", operationId="updatePayment", tags={"Payments"}, security={{"bearerAuth":{}}}, summary="Update payment", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/PaymentRequest")), @OA\Response(response=200, description="Updated"))
     * @OA\Delete(path="/api/v1/payments/{id}", operationId="deletePayment", tags={"Payments"}, security={{"bearerAuth":{}}}, summary="Hapus payment", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Deleted"))
     */
    public function paymentDetail(): void
    {
    }

    #[OA\Get(path: '/api/v1/payments/{id}', operationId: 'showPayment', tags: ['Payments'], security: [['bearerAuth' => []]], summary: 'Detail payment', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Put(path: '/api/v1/payments/{id}', operationId: 'updatePayment', tags: ['Payments'], security: [['bearerAuth' => []]], summary: 'Update payment', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/PaymentRequest')), responses: [new OA\Response(response: 200, description: 'Updated')])]
    #[OA\Delete(path: '/api/v1/payments/{id}', operationId: 'deletePayment', tags: ['Payments'], security: [['bearerAuth' => []]], summary: 'Hapus payment', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Deleted')])]
    public function paymentDetailAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/stock-movements")
     * @OA\Get(path="/api/v1/stock-movements", operationId="listStockMovements", tags={"Stock Movements"}, security={{"bearerAuth":{}}}, summary="Daftar stock movement", @OA\Parameter(ref="#/components/parameters/PerPage"), @OA\Response(response=200, description="Sukses"))
     * @OA\Post(path="/api/v1/stock-movements", operationId="storeStockMovement", tags={"Stock Movements"}, security={{"bearerAuth":{}}}, summary="Tambah stock movement", @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StockMovementRequest")), @OA\Response(response=201, description="Created"))
     */
    public function stockMovements(): void
    {
    }

    #[OA\Get(path: '/api/v1/stock-movements', operationId: 'listStockMovements', tags: ['Stock Movements'], security: [['bearerAuth' => []]], summary: 'Daftar stock movement', parameters: [new OA\Parameter(ref: '#/components/parameters/PerPage')], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Post(path: '/api/v1/stock-movements', operationId: 'storeStockMovement', tags: ['Stock Movements'], security: [['bearerAuth' => []]], summary: 'Tambah stock movement', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/StockMovementRequest')), responses: [new OA\Response(response: 201, description: 'Created')])]
    public function stockMovementsAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/stock-movements/{id}")
     * @OA\Get(path="/api/v1/stock-movements/{id}", operationId="showStockMovement", tags={"Stock Movements"}, security={{"bearerAuth":{}}}, summary="Detail stock movement", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Sukses"))
     * @OA\Put(path="/api/v1/stock-movements/{id}", operationId="updateStockMovement", tags={"Stock Movements"}, security={{"bearerAuth":{}}}, summary="Update stock movement", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StockMovementRequest")), @OA\Response(response=200, description="Updated"))
     */
    public function stockMovementDetail(): void
    {
    }

    #[OA\Get(path: '/api/v1/stock-movements/{id}', operationId: 'showStockMovement', tags: ['Stock Movements'], security: [['bearerAuth' => []]], summary: 'Detail stock movement', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Sukses')])]
    #[OA\Put(path: '/api/v1/stock-movements/{id}', operationId: 'updateStockMovement', tags: ['Stock Movements'], security: [['bearerAuth' => []]], summary: 'Update stock movement', parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/StockMovementRequest')), responses: [new OA\Response(response: 200, description: 'Updated')])]
    public function stockMovementDetailAttr(): void
    {
    }
}
