<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Resources\BookingCollection;
use App\Http\Resources\BookingResource;
use App\Http\Resources\LessonCollection;
use App\Models\Customer;
use App\Models\Lesson;
use App\Notification\BookingConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExampleMail;

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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookingRequest $request)
    {
        $lessonId = $request->json('lessonId');
        $customerId = $request->json('customerId');

        // dettagli del lezione e del relativo corso
        $count = Booking::where('lesson_id', $lessonId)->count();
        $lesson = Lesson::where('id', $lessonId)->first();
        $course = $lesson->course;

        // dettagli del cliente
        $customer = Customer::where('id', $customerId)->first();
        $dateExipMemb = date('Y-m-d H:i:s', strtotime($customer->updated_at . " + $customer->membership_duration month"));;
        $currDateTime = date('Y-m-d H:i:s');

        // controllo sul raggiungimento della capacità massima
        if ($count == $lesson->max_capacity) {
            $otherCourses = Lesson::where('id', '<>', $lessonId)
                    ->where('course_id', $lesson->course_id)
                    ->whereRaw("DATE(start_time) = DATE('{$lesson->start_time}')")
                    ->get();

            return response()->json([
                'message' => 'Per questa lezione è stato già raggiunto il massimo dei partecipanti. Ecco a te altre proposte, per la giornata odierna, per lo stesso corso.',
                'altriCorsi' => new LessonCollection($otherCourses)
            ]);
        
        } elseif ($dateExipMemb < $currDateTime ) { // controllo sulla validità dell'abbonamento

            return response()->json(['message' => 'Il tuo abbonamento risulta scaduto. Procedi al rinnovo.' ]);
        
        } else { // salvataggio della prenotazione con invio email di conferma

            $booking = Booking::create($request->all());
            $user = $booking->customer;
            $subject = 'Conferma Prenotazione Corso - ' . $course->name;
            $message =  'La tua prenotazione per la lezione è andata a buon fine. Buon allenamento! ';
            Mail::to($user->email)->send(new ExampleMail($user->name, $message, $subject));
            //return new BookingResource($booking);
            return response()->json(['message' => $message . 'A breve riceverai una mail di conferma' ]);

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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookingRequest  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        try {
            $booking->update($request->all());
            return response()->json(['message' => 'La tua prenotazione è stata correttamente modificata.' ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Errore nella modifica della prenotazione.' ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
            return response()->json(['message' => 'La tua prenotazione è stata correttamente cancellata.' ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Errore nella cancellazione della prenotazione' ]);
        }
    }
}
