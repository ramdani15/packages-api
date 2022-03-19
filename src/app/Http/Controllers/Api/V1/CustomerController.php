<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Http\Requests\Api\V1\CustomerRequest;
use App\Http\Resources\Api\V1\CustomerResource;
use App\Repositories\Api\V1\CustomerRepository;

class CustomerController extends Controller
{
    use ApiResponse;

    public function __construct(
        Customer $customer,
        CustomerRepository $customerRepository
    ) {
        $this->customer = $customer;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/customers",
     *      summary="List Customers",
     *      description="Get List Customers",
     *      tags={"Customers"},
     *      @OA\Parameter(
     *          name="location_id",
     *          in="query",
     *          description="Locaiton ID"
     *      ),
     *      @OA\Parameter(
     *          name="organization_id",
     *          in="query",
     *          description="Organization ID"
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="Name"
     *      ),
     *      @OA\Parameter(
     *          name="code",
     *          in="query",
     *          description="Code"
     *      ),
     *      @OA\Parameter(
     *          name="address",
     *          in="query",
     *          description="Address"
     *      ),
     *      @OA\Parameter(
     *          name="address_detail",
     *          in="query",
     *          description="Address Detail"
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          description="Email"
     *      ),
     *      @OA\Parameter(
     *          name="phone",
     *          in="query",
     *          description="Phone"
     *      ),
     *      @OA\Parameter(
     *          name="nama_sales",
     *          in="query",
     *          description="Nama Sales"
     *      ),
     *      @OA\Parameter(
     *          name="top",
     *          in="query",
     *          description="Top"
     *      ),
     *      @OA\Parameter(
     *          name="jenis_pelanggan",
     *          in="query",
     *          description="Jenis Pelanggan"
     *      ),
     *      @OA\Parameter(
     *          name="sort",
     *          in="query",
     *          description="1 for Ascending -1 for Descending"
     *      ),
     *      @OA\Parameter(
     *          name="sort_by",
     *          in="query",
     *          description="Field to sort"
     *      ),
     *      @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="Limit (Default 10)"
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Num Of Page"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object", example={}),
     *              @OA\Property(property="pagination", type="object", example={}),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Failed to Get Customers."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function index(Request $request)
    {
        try {
            $customers = $this->customerRepository->searchCustomers($request);
            return $this->responseJson('pagination', 'Get Customers Successfully.', $customers, 200, [$request->sort_by, $request->sort]);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Customers.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/customers",
     *      summary="Create Customer",
     *      description="Create Customer",
     *      tags={"Customers"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass customer credentials",
     *          @OA\JsonContent(
     *              required={"location_id", "organization_id", "name", "code", "address", "email", "phone"},
     *              @OA\Property(property="location_id", type="number", example=1),
     *              @OA\Property(property="organization_id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="name1"),
     *              @OA\Property(property="code", type="string", example="code1"),
     *              @OA\Property(property="address", type="string", example="address1"),
     *              @OA\Property(property="address_detail", type="string", example=null),
     *              @OA\Property(property="email", type="string", format="email", example="email1@mail.com"),
     *              @OA\Property(property="phone", type="string", example="+1231232"),
     *              @OA\Property(property="nama_sales", type="string", example=null),
     *              @OA\Property(property="top", type="string", example=null),
     *              @OA\Property(property="jenis_pelanggan", type="string", example=null),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="location_id", type="number", example=1),
     *              @OA\Property(property="organization_id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="name1"),
     *              @OA\Property(property="code", type="string", example="code1"),
     *              @OA\Property(property="address", type="string", example="address1"),
     *              @OA\Property(property="address_detail", type="string", example=null),
     *              @OA\Property(property="email", type="string", format="email", example="email1@mail.com"),
     *              @OA\Property(property="phone", type="string", example="+1231232"),
     *              @OA\Property(property="nama_sales", type="string", example=null),
     *              @OA\Property(property="top", type="string", example=null),
     *              @OA\Property(property="jenis_pelanggan", type="string", example=null),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Wrong Credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example={}),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Failed to Create Customer."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     *  )
     */
    public function store(CustomerRequest $request)
    {
        try {
            $customer = $this->customer->create($request->validated());
            return $this->responseJson('created', 'Create Customer Successfully.', $customer, 201);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Create Customer.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/customers/{id}",
     *      summary="Detail Customer",
     *      description="Get Detail Customer",
     *      tags={"Customers"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="location_id", type="number", example=1),
     *              @OA\Property(property="organization_id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="name1"),
     *              @OA\Property(property="code", type="string", example="code1"),
     *              @OA\Property(property="address", type="string", example="address1"),
     *              @OA\Property(property="address_detail", type="string", example=null),
     *              @OA\Property(property="email", type="string", format="email", example="email1@mail.com"),
     *              @OA\Property(property="phone", type="string", example="+1231232"),
     *              @OA\Property(property="nama_sales", type="string", example=null),
     *              @OA\Property(property="top", type="string", example=null),
     *              @OA\Property(property="jenis_pelanggan", type="string", example=null),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Customer Not Found."),
     *              @OA\Property(property="code", type="number", example=404),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Wrong Credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example={}),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Failed to Get Detail Customer."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function show(CustomerRequest $request)
    {
        try {
            $customer = $this->customer->find($request->id);
            if (!$customer) {
                return $this->responseJson('error', 'Customer Not Found', '', 404);
            }
            $customer = new CustomerResource($customer);
            return $this->responseJson('success', 'Get Detail Customer Successfully.', $customer);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Get Detail Customer.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/customers/{id}",
     *      summary="Update Customer",
     *      description="Update Data Customer",
     *      tags={"Customers"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass customer credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="update name1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="location_id", type="number", example=1),
     *              @OA\Property(property="organization_id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="update name1"),
     *              @OA\Property(property="code", type="string", example="code1"),
     *              @OA\Property(property="address", type="string", example="address1"),
     *              @OA\Property(property="address_detail", type="string", example=null),
     *              @OA\Property(property="email", type="string", format="email", example="email1@mail.com"),
     *              @OA\Property(property="phone", type="string", example="+1231232"),
     *              @OA\Property(property="nama_sales", type="string", example=null),
     *              @OA\Property(property="top", type="string", example=null),
     *              @OA\Property(property="jenis_pelanggan", type="string", example=null),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Customer Not Found."),
     *              @OA\Property(property="code", type="number", example=404),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Wrong Credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example={}),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Failed to Update Data Customer."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function update(CustomerRequest $request)
    {
        try {
            $customer = $this->customer->find($request->id);
            if (!$customer) {
                return $this->responseJson('error', 'Customer Not Found', '', 404);
            }
            $customer->update($request->validated());
            $customer = new CustomerResource($this->customer->find($customer->id));
            return $this->responseJson('success', 'Update Customer Successfully.', $customer);
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Update Customer.', $th, $th->getCode() ?? 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/customers/{id}",
     *      summary="Delete Customer",
     *      description="Delete Data Customer",
     *      tags={"Customers"},
     *      @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID"
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="No Content",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Customer Not Found."),
     *              @OA\Property(property="code", type="number", example=404),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Wrong Credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example={}),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Failed to Delete Customer."),
     *              @OA\Property(property="code", type="number", example=500),
     *              @OA\Property(property="error", type="string", example="Something Wrong."),
     *          )
     *      ),
     * )
     */
    public function destroy(CustomerRequest $request)
    {
        try {
            $customer = $this->customer->find($request->id);
            if (!$customer) {
                return $this->responseJson('error', 'Customer Not Found', '', 404);
            }
            $customer->delete();
            return $this->responseJson('deleted', 'Delete Customer Successfully.');
        } catch (\Throwable $th) {
            return $this->responseJson('error', 'Failed to Delete Customer.', $th, $th->getCode() ?? 500);
        }
    }
}
