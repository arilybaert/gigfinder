@extends('layouts.app')
@section('content')

<div class="o-gallery" id="o-gallery">
    <div class="m-gallery" id="m-gallery">
        <h2>Gallery</h2>
        <div class="m-photo" id="m-photo">
            @foreach ($photo_files as $photo_file)
                {{-- uncomment to use db pictures --}}
                @if (env('STORAGE') === 'public')
                    <img src="{{asset($photo_file) }}" alt="gallery picture" class="a-gallery-picture">
                @elseif(env('STORAGE') === 's3')
                <img src="{{env('AWS_URL') . $photo_file}}" alt="gallery picture" class="a-gallery-picture">
                @endif
                @endforeach
                <div class="a-left a-image-button" id="a-left">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <div class="a-right a-image-button" id="a-right">
                    <i class="fas fa-arrow-right"></i>
                </div>
        </div>
        <div class="m-gallery-video" id="o-gallery-video">
            <iframe class="a-gallery-video" src="{{env('VIMEO_URL') . $artist->vimeo_id}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
        </div>
        <i class="fas fa-video a-video" id="a-photo-video-btn"></i>
        <i class="fas fa-camera a-video" id="a-photo-video-btn_photo"></i>
    </div>
</div>

{{-- image --}}
<div class="row">
    <div class="col-10 offset-1 o-artist-detail-cover" id="a-gallery-open">
        @if (env('STORAGE') === 'public')
            <img src="{{ asset($artist->coverphoto) }}" class="a-artist-detail-cover">
        @elseif(env('STORAGE') === 's3')
            <img src="{{env('AWS_URL') . $artist->coverphoto}}" class="a-artist-detail-cover">
        @endif
        <h2>{{$artist->name}}</h2>
        <i class="fas fa-camera"></i>
    </div>
</div>

{{-- artist details --}}
<div class="row">
    <div class="col-10 offset-1 m-artist-details" id="m-artist-details">
        <div class="row">
            <div class="col-10">
                <div class="row">
                    @foreach($artist->bandmembers as $bandmember)
                        <div class="col-3 m-artist-members">
                            @if (env('STORAGE') === 'public')
                                <img src="{{ asset($bandmember->photo)}}" alt="">
                            @elseif(env('STORAGE') === 's3')
                                <img src="{{env('AWS_URL') . $bandmember->photo}}">
                            @endif
                            <h5>{{$bandmember->function}}</h5>
                            <h4>{{$bandmember->name}}</h4>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

{{-- artist description and contact information --}}
<div class="row o-artist-detail">
    <div class="col-10 offset-1">
        <div class="row">
            {{-- artist description  --}}
            <div class="col-8">
                <div class="row">
                    <div class="col-12">
                        <h3>
                            Genre
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>
                            {{ $artist->genre_description}}
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h3>
                            Description
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>
                            {{ $artist->description}}
                        </p>
                    </div>
                </div>
                <div class="row ">
                    <a href="{{route('download.rider', $artist->id)}}" class="col-4 offset-4 a-rider-button">
                        Download rider
                    </a>
                </div>
            </div>
            {{-- artist contact information --}}
            <div class="col-4">
                <div class="row">
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
                                {{ $artist->zipcode . ', ' . $artist->city}}
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
                                {{ $artist->telephone}}
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
                                {{ $artist->website}}
                            </div>
                        </div>

                    </div>
                </div>


                <div class="row o-apply-button">
                            <button class="a-apply-button" id="a-applyBtn">Our music</button>

                            @foreach ($song_files as $song_file)
                                @if ( $loop->index < 4)
                                <div class="col-3 a-apply-color-{{$loop->index+=1}} o-song">
                                    <div class="m-img-container a-button">
                                        @if (env('STORAGE') === 's3')
                                            <audio  classname="a-player" src="{{env('AWS_URL') . $song_file}}"></audio>
                                        @endif
                                        @if(env('STORAGE') === 'public')
                                            <audio  classname="a-player" src="{{asset($song_file)}}"></audio>
                                        @endif
                                        <img src="{{asset('img/logo/songCover/cover-2.png')}}" alt="" class="a-spinning-cover">
                                        <i class="fas fa-play"></i>
                                        <i class="fas fa-pause"></i>
                                    </div>
                                </div>
                                @endif

                            @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">

        {{-- <div class="row">
            <div class="o-media-buttons">

            </div>
        </div> --}}



    </div>

</div>
<div class="o-apply-form" id="o-apply-form">
    <div class="row m-apply-form">
        <div class="col-6 offset-3">
            <form action="" id="o-form">
                <div class="row">
                    <div class="col-12">
                        <h2>Apply now</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-10 offset-1">
                        <label for="content">Message</label>
                        <textarea name="content" id="" class="a-textarea"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-10 offset-1">
                        <button type="submit">Send application</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
