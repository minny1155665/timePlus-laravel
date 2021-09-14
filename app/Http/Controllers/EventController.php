<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Event;
use App\Models\User;
use App\Services\EventService;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = (new Event)->where('status', 'not_yet')->orderBy('created_at', 'desc')->paginate(20);
        
        return view('index', ['events' => $events]);
    }

    /**
     * show
     */
    public function show(Event $event)
    {
        return view('eventMore', ['event' => $event]);
    }

    // show if places of attendees and helpers remaining
    public static function showAttend()
    {
        $all_events = Event::get();
        foreach ($all_events as $event)
        {
            (new EventService())->setAttendeeRemainingEvent($event);
        }
        $events = (new Event)
                ->where('status', 'not_yet')
                ->where('attend_remain', '=', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        
        return view('index', ['events' => $events]);
    }

    public static function showHelp()
    {
        $all_events = Event::get();
        foreach ($all_events as $event)
        {
            (new EventService())->setHelperRemainingEvent($event);
        }
        $events = (new Event)
                ->where('status', 'not_yet')
                ->where('help_remain', '=', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
                
        return view('index', ['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Event $event)
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Event $event)
    {
        // validation
        request()->validate([
            'hold_points' => 'nullable',
            'help_points' => 'nullable',
            //最大10000kb
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000'
        ]);

        $event->name = $request->input('name');
        $event->holder = Auth::id();
        $event->date = $request->input('date');
        $event->time = $request->input('time');
        $event->location = $request->input('location');
        $event->help_num = $request->input('help');
        $event->attend_num = $request->input('attend');
        $event->attend_points = $request->input('point');
        $event->content = $request->input('content');

        // save image  to upload file
		$image_name = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];
        $event->image = 'storage/upload/'.$image_name;
        $event->save();

        $image = Image::make($image_temp);
        $image->save(public_path($event->image), 60);   

        // attach user with additional pivot data (user_role)
        $event->users()->attach(Auth::id(), ['user_role' => 'holder']);
        return redirect(url('/'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('events.edit', ['event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $event->name = $request->input('name');
        $event->date = $request->input('date');
        $event->time = $request->input('time');
        $event->location = $request->input('location');
        $event->help_num = $request->input('help');
        $event->attend_num = $request->input('attend');
        $event->attend_points = $request->input('point');
        $event->content = $request->input('content');
        $event->save();

        // save image  to upload file
        if (is_uploaded_file($_FILES["image"]["tmp_name"]))
        {
            $image_name = $_FILES['image']['name'];
            $image_temp = $_FILES['image']['tmp_name'];
            $event->image = 'storage/upload/'.$image_name;
            $event->save();

            $image = Image::make($image_temp);
            $image->save(public_path($event->image), 60); 
        }
		       
        return redirect(url('/'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();

        // delete image
        $image_path = 'public/'.$event->image;
        if (Storage::exists($image_path))
        {
            Storage::delete($image_path);
        }

        // detach user with additional pivot data (user_role)
        $event->users()->detach();

        return redirect()->back();
    }

    // favorite
    public static function favorite(Event $event)
    {
        $event_id = $event->id;
        return (new EventService())->favorite($event_id);
    }

    public static function isFavorite(Event $event)
    {
        $event_id = $event->id;
        return (new EventService())->isFavorite($event_id);
    }

    public static function cancelFav(Event $event)
    {
        $event_id = $event->id;
        return (new EventService())->cancelFav($event_id);
    }

    // attend & help
    public static function attend(Event $event)
    {
        $event_id = $event->id;
        return (new EventService())->attend($event_id);
    }  

    public static function help(Event $event)
    {
        $event_id = $event->id;
        return (new EventService())->help($event_id);
    }

    public static function isAttended(Event $event)
    {
        $event_id = $event->id;
        return (new EventService())->isAttended($event_id);
    }

    public static function cancelAttend(Event $event)
    {
        $event_id = $event->id;
        return (new EventService())->cancelAttend($event_id);
    }

    // end event
    public function endEvent(Event $event)
    {
        $event_id = $event->id;
        $event_service = new EventService();
        $event_service->endEvent($event_id);
        $event_service->calculate($event_id);
        $event_service->distribute($event_id);
        return redirect()->back();
    }

    // else
    public static function getHolderName($event_id)
    {
        return (new EventService())->getHolderName($event_id);
    }

}
