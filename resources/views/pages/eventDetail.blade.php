@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12 o-event-detail-cover">
        <img src="{{ asset($event->user->coverphoto) }}" alt="" class="a-event-detail-cover">
        <h2>{{$event->user->name}}</h2>
    </div>
</div>
<div class="row o-event-detail">
    <div class="col-3">
        <div class="row">
            <h3>
                Media
            </h3>
        </div>
        <div class="row">
            <div class="o-media-buttons">
                <div class="m-media-buttons">
                    <i class="fas fa-camera"></i>
                </div>
                <div class="m-media-buttons">
                    <i class="fas fa-video"></i>
                </div>
            </div>
        </div>
        <div class="row">
            <h3>
                Information
            </h3>
            <div class="o-information">
                <div class="row m-information">
                    <div class="col-2">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="col-9">
                        <h4>
                            Address
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9 offset-2">
                        {{ $event->user->address}},
                        <br>
                        {{ $event->user->city . ' ' . $event->user->zipcode}}
                    </div>
                </div>

                <div class="row m-information">
                    <div class="col-2">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="col-9">
                        <h4>
                            Telephone
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9 offset-2">
                        {{ $event->user->telephone}}
                    </div>
                </div>

                <div class="row m-information">
                    <div class="col-2 m-information-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="col-9">
                        <h4>
                            Website
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9 offset-2">
                        {{ $event->user->website}}
                    </div>
                </div>

            </div>
        </div>

        <div class="row o-apply-button">
            <button class="a-apply-button">Apply now</button>
            <div class="col-3 a-apply-color-1"></div>
            <div class="col-3 a-apply-color-2"></div>
            <div class="col-3 a-apply-color-3"></div>
            <div class="col-3 a-apply-color-4"></div>
        </div>
    </div>
    <div class="col-8 offset-1 o-event-detail-main">
        <div class="row">
            <div class="col-12">
                <h3>
                    {{ $event->name}}
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p>
                    {{ $event->description}}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3>
                    Gig details
                </h3>
            </div>
            <div class="row">
                <div class="col-3 col-lg-2 m-event-detail-tags">
                    <i class="fas fa-users a-event-detail-tags-icon"></i>
                    <h4>Capacity</h4>
                    <h5>{{ $event->user->capacity }}</h5>
                </div>
                <div class="col-3 col-lg-2 m-event-detail-tags">
                    <i class="fas fa-music a-event-detail-tags-icon"></i>
                    <h4>Genre</h4>
                    <h5>{{ $event->genre->name }}</h5>

                </div>
                <div class="col-3 col-lg-2 m-event-detail-tags">
                    <i class="far fa-calendar-alt a-event-detail-tags-icon"></i>
                    <h4>Date</h4>
                    <h5>{{ date("d/m/Y",strtotime($event->date)) }}</h5>

                </div>
                <div class="col-3 col-lg-2 m-event-detail-tags">
                    <i class="fas fa-volume-up a-event-detail-tags-icon"></i>
                    <h4>PA</h4>
                    <h5>{{ $event->user->pa->name }}</h5>

                </div>
                <div class="col-3 col-lg-2 m-event-detail-tags">
                    <i class="fas fa-microphone a-event-detail-tags-icon"></i>
                    <h4>Microphones</h4>
                    @foreach($event->user->microphones as $microphone)
                        <h5>{{$microphone->microphone->name}}</h5>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
