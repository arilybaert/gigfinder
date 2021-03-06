<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Pa;
use App\Models\User;
use App\Models\Event;
use App\Models\Microphone;
use App\Models\MicrophonesUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;

class EventController extends Controller
{
    public function getIndex()
    {
        return view('event.home');
    }
    // show all events from event-user
    public function getEvents()
    {
        $now = Carbon::now();
        if (Auth::check()){
            $user_id = Auth::id();
            $future_events = Event::where('user_id', $user_id)->where('date', '>', $now)->orderBy('date', 'asc')->get();
            $passed_events = Event::where('user_id', $user_id)->where('date', '<', $now)->orderBy('date', 'asc')->get();
        }


        return view('pages.profile.profile-event.profile-event', [
            'future_events' => $future_events,
            'passed_events' => $passed_events,
        ]);
    }
    // event applicants
    public function getEventApplicants(Event $event)
    {
        // dd($event);
        return view('pages.applicants', [
        'event' => $event
        ]);
    }
    public function acceptApplicant(Event $event, User $accepted_applicant)
    {
        foreach ($event->applicants as $applicant) {
            if($applicant->user->id == $accepted_applicant->id) {
                /*
                *** Let the applicant know he's being selected
                */
                $applicant->update([['status' => 'accepted']]);
                $to_name = $applicant->user->name;
                $to_email = $applicant->user->email;
                $body = "Good news! The host from " . $applicant->event->name . " has accepted your application";
                $data = array('name'=>$to_name, "body" => $body);

                Mail::send('emails.mail_application_status', $data, function($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                            ->subject('New application!');
                    $message->from('gigfinder.ahs@gmail.com','Gigfinder');
                });

                /*
                *** Let event know he has chosen an applicant
                */
                $to_name = $event->user->name;
                $to_email = $event->user->email;
                $body = "You've accepted " . $applicant->user->name . " as artist for your event.";
                $data = array('name'=>$to_name, "body" => $body);

                Mail::send('emails.mail_application_status', $data, function($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                            ->subject('New application!');
                    $message->from('gigfinder.ahs@gmail.com','Gigfinder');
                });
            } else {
                /*
                *** Let other applicants know there being rejected
                */
                $applicant->update(['status' => 'rejected']);
                $to_name = $applicant->user->name;
                $to_email = $applicant->user->email;
                $body = "We're sorry to infrom you that the host from " . $applicant->event->name . " has rejected your application. Go check out other events on our site below";
                $data = array('name'=>$to_name, "body" => $body);

                Mail::send('emails.mail_application_status', $data, function($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                            ->subject('Application info');
                    $message->from('gigfinder.ahs@gmail.com','Gigfinder');
                });
            };

        }
        return back();
    }

    public function rejectApplicant(Event $event, User $rejected_applicant, Applicant $application)
    {

        /*
        *** Let other applicants know there being rejected
        */
        $application->update(['status' => 'rejected']);
        $to_name = $rejected_applicant->name;
        $to_email = $rejected_applicant->email;
        $body = "We're sorry to infrom you that the host from " . $event->name . " has rejected your application. Go check out other events on our site below";
        $data = array('name'=>$to_name, "body" => $body);

        Mail::send('emails.mail_application_status', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                    ->subject('Application info');
            $message->from('gigfinder.ahs@gmail.com','Gigfinder');
        });
        return back();
    }

    // edit event
    public function editEvent(Event $event)
    {


    }
    // create event
    public function createEvent(Event $event)
    {

        $pas = Pa::all();
        $microphones = Microphone::all();
        return view('pages.profile.profile-event.create-event', [
            'event' => $event,
            'microphones' => $microphones,
            'pas' => $pas
        ]);
    }
    // save event
    public function saveEvent(Request $r)
    {
        $event_data = [
            'name' => $r->name,
            'date' => $r->date,
            'description' => $r->description,
            'coverphoto' => $r->coverphoto_path,
            'user_id' => Auth::id(),
            'genre_id' => 14,
            'created_at' => Carbon::now()
        ];
        if($r->id !== null) {
            $event = Event::where('id', $r->id)->first();
            $event->update($event_data);
        } else {

            $event = Event::create($event_data);

        }


        return redirect()->route('event.profile.events');

    }

    // edit user-event profile
    public function editProfileEvent()
    {
        $user = User::where('id', Auth::id())->first();

        $microphones = Microphone::all();
        $pas = Pa::all();

        $user_microphones = [];
        foreach ($user->microphones as $mic) {
            array_push($user_microphones, $mic->microphone_id);
        }

        return view('pages.profile.profile', [
            'user' => $user,
            'microphones' => $microphones,
            'user_microphones' => $user_microphones,
            'pas' => $pas
        ]);
    }
    public function saveProfileEvent(Request $r)
    {
        if($r->microphones !== null){
            MicrophonesUser::where('user_id',$r->id)->delete();
            foreach ($r->microphones as $microphone) {
                $data = [
                    'user_id' => $r->id,
                    'microphone_id' => $microphone
                ];
                MicrophonesUser::create($data);
            }
        }
        $arrLocation = explode(',', $r->location);
        $data = [
            'name' => $r->name,
            'telephone' => $r->telephone,
            'address' => $r->address,
            'zipcode' => $r->zipcode,
            'city' => $arrLocation[0],
            'latitude' => $r->latitude,
            'longitude' => $r->longitude,
            'website' => $r->website,
            'capacity' => $r->capacity,
            'description' => $r->description,
            'genre_description' => $r->genre_description,
            'vimeo_id' => $r->vimeo_id,
            'pa_id' => $r->pa_id,
        ];

        if($r->id){
            $user = User::where('id', $r->id)->first();
            $user->update($data);
        }
        return back();

    }
    // change password user-event
    public function changePassword()
    {

        return view('pages.profile.password');
    }
    // show all user-event media
    public function getEventMedia()
    {

        return view('pages.profile.media', [

        ]);
    }
}
