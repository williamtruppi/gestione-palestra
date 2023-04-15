<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\CustomerCollection;
use Illuminate\Http\Request;

// use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $fltArr['email'] = $request->query('email') ?? '';
        $fltArr['membership_type'] = $request->query('membership_type') ?? '';
        $fltArr['membership_duration'] = $request->query('membership_duration') ?? '';
        $fltArr['membership_status'] = $request->query('membership_status') ?? '';
        $fltArr['membership_status'] = $request->query('membership_status') ?? '';
        $fltArr['bookings'] = $request->query('bookings') ?? 0;

        $fltArr['cards'] = $request->query('cards') ?? false;

        $result = \App\Models\Customer::getCustomers($fltArr);

        return new CustomerCollection($result);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {

        $fltArr['bookings'] = request()->query('bookings') ?? 0;

        if ($fltArr['bookings']) {
            return new CustomerResource($customer->loadMissing('bookings'));
        }

        return new CustomerResource($customer);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
