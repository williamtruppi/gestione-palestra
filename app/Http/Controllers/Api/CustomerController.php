<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\CustomerCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExampleMail;

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

    public function CheckAbbonamenti()
    {
        
        $msgJson = [];

        $customers = Customer::whereIn('membership_status', [1, 2])->get();

        foreach ($customers as $k => $v) {

            $dateExipMemb = date('Y-m-d H:i:s', strtotime($v->updated_at . " + $v->membership_duration month"));;
            $currDateTime = date('Y-m-d H:i:s');
            
            if ($dateExipMemb < $currDateTime || $v->membership_status == 2) { // se l'abbonamento è scaduto

                try {
                    $customer = Customer::find($v->id); // recupera il record con id=1
                    $customer->membership_status = 2; // aggiorna il valore del campo membership_status
                    $customer->save(); // salva le modifiche sul database
                } catch (\Throwable $th) {
                    throw $th;
                }

                $subject = 'Avviso Abbonamento Scaduto';
                $message =  'Ti ricordiamo che il tuo abbonamento risulta scaduto. Procedi a rinnovarlo tramite l\'app o direttamente
                da noi in palestra. Qualora non fossi più interessato, comunicaci la tua volontà di interrompere la tua sottoscrizione';
                
                try {
                    // Mail::to($v->email)->send(new ExampleMail($v->name, $message, $subject));
                    $msgJson[] = $v->name . '- email inviata';
                } catch (\Throwable $th) {
                    return response()->json(['message' => 'Errore nell\'invio della mail.']);
                }
            
            } elseif ($v->membership_status == 1) {
                
                $diff = strtotime($currDateTime) - strtotime($dateExipMemb);
                $days = round($diff / (60 * 60 * 24));

                if ($days > 0 && $days <= 15) {
                    $subject = 'Avviso Abbonamento in Scadenza';
                    $message =  'Ti ricordiamo che il tuo abbonamento scadrà tra 15. Procedi a rinnovarlo tramite l\'app o direttamente
                    da noi in palestra. Qualora non fossi più interessato, comunicaci la tua volontà di interrompere la tua sottoscrizione';                
                    
                    try {
                        //Mail::to($v->email)->send(new ExampleMail($v->name, $message, $subject));
                        $msgJson[] = $v->name . '- email inviata';
                    } catch (\Throwable $th) {
                        return response()->json(['message' => 'Errore nell\'invio della mail.']);
                    }
                }

            }

            


        } 

        return response()->json(['message' => $msgJson]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        // echo($request);
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
