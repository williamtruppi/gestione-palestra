<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Resources\BookingCollection;
use App\Http\Resources\BookingResource;
use App\Models\Customer;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BookingController extends Controller
{
    /* public function __construct()
    {
        $this->middleware('can:viewAny,App\Models\Booking')->only('index');
        $this->middleware('can:create,App\Models\Booking')->only('store');
        $this->middleware('can:update,booking')->only('update');
        $this->middleware('can:delete,booking')->only('destroy');
    } */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $bookings = Booking::join('customers', 'bookings.customer_id', '=', 'customers.id')
        ->join('lessons', 'bookings.lesson_id', '=', 'lessons.id')
        ->join('courses', 'lessons.course_id', '=', 'courses.id')
        ->select('bookings.*', 'lessons.*', 'customers.name as customer_name', 'courses.name as course_name')
        ->get();


        return new BookingCollection($bookings);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookingRequest $request)
    {
        $lessonId = $request->json('lessonId');
        $customerId = $request->json('customerId');

        $count = Booking::where('lesson_id', $lessonId)->count();
        $lesson = Lesson::where('id', $lessonId)->first();

        $customer = Customer::where('id', $customerId)->first();
        $dateExipMemb = date('Y-m-d H:i:s', strtotime($customer->updated_at . " + $customer->membership_duration month"));;
        $currDateTime = date('Y-m-d H:i:s');

        if ($count == $lesson->max_capacity) {
            return response()->json(['message' => 'Per questa lezione è stato già raggiunto il massimo dei partecipanti.']);
        } elseif ( $dateExipMemb < $currDateTime ) {

            $otherCourses = Lesson::where('id', '<>' , $lessonId)
                            ->where('course_id', $lesson->course_id)
                            ->get();

            return response()->json([
                'message' => 'Il tuo abbonamento risulta scaduto. Procedi al rinnovo.',
                'altriCorsi' => new LessonCollection($otherCourses)
            ]);
        } else {
            return new BookingResource(Booking::create($request->all()));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookingRequest  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
