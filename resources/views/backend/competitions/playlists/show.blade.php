@extends('motor-backend::layouts.backend')

@section('view_styles')
    @include('partymeister-slides::layouts.partials.slide_fonts')
    <style type="text/css">
        .slidemeister-instance {
            zoom: 0.75;
            float: left;
            margin-right: 15px;
            margin-bottom: 15px;
        }

        .weg {
            display: none !important;
        }
    </style>
@append
@section('htmlheader_title')
    {{ trans('motor-backend::backend/global.home') }}
@endsection

@section('contentheader_title')
    {{ trans('partymeister-competitions::backend/competitions.playlist_preview') }}
    <button class="btn btn-sm btn-success float-right competition-playlist-save">{{trans('partymeister-competitions::backend/competitions.save_playlist')}}</button>
    {!! link_to_route('backend.competitions.index', trans('motor-backend::backend/global.back'), [], ['class' => 'float-right btn btn-sm btn-danger']) !!}
@endsection

@section('main-content')
    <form id="competition-playlist-save"
          action="{{route('backend.competitions.playlist.store', ['competition' => $competition->id])}}" method="POST">
        @csrf
        <div class="@boxWrapper box-primary" style="margin-bottom: 0;">
            <div class="@boxBody">
                <div id="slidemeister-competition-comingup" class="slidemeister-instance"></div>
                {{--<div style="display: none">--}}
                <div id="slidemeister-competition-comingup-preview" class="slidemeister-instance"></div>
                <div id="slidemeister-competition-comingup-final" class="slidemeister-instance"></div>
                {{--</div>--}}
                <input type="hidden" name="slide[comingup]">
                <input type="hidden" name="preview[comingup]">
                <input type="hidden" name="final[comingup]">
                <input type="hidden" name="type[comingup]" value="comingup">
                <input type="hidden" name="name[comingup]" value="Coming up">
                @foreach ($videos as $index => $video)
                    <div class="slidemeister-instance">
                        <img src="{{$video['data']['preview']}}" style="width: 100%;">
                        <input type="hidden" name="slide[video_{{$index+1}}]"
                               value="{{ json_encode($video, JSON_UNESCAPED_SLASHES) }}">
                        <input type="hidden" name="type[video_{{$index+1}}]" value="video_{{$index+1}}">
                        <input type="hidden" name="name[video_{{$index+1}}]" value="Video {{$index+1}}">
                    </div>
                @endforeach
                <div id="slidemeister-competition-now" class="slidemeister-instance"></div>
                <div id="slidemeister-competition-now-preview" class="slidemeister-instance"></div>
                <div id="slidemeister-competition-now-final" class="slidemeister-instance"></div>

                <input type="hidden" name="slide[now]">
                <input type="hidden" name="preview[now]">
                <input type="hidden" name="final[now]">
                <input type="hidden" name="type[now]" value="now">
                <input type="hidden" name="name[now]" value="Now">
                @foreach($entries as $index => $entry)
                    <div id="slidemeister-entry-{{$entry['id']}}" class="slidemeister-instance"></div>
                    <div id="slidemeister-entry-{{$entry['id']}}-preview" class="slidemeister-instance"></div>
                    <div id="slidemeister-entry-{{$entry['id']}}-final" class="slidemeister-instance"></div>
                    <input type="hidden" name="slide[entry_{{$entry['id']}}]">
                    <input type="hidden" name="preview[entry_{{$entry['id']}}]">
                    <input type="hidden" name="final[entry_{{$entry['id']}}]">
                    <input type="hidden" name="type[entry_{{$entry['id']}}]" value="entry">
                    <input type="hidden" name="name[entry_{{$entry['id']}}]" value="Entry #{{$index+1}}">
                    <input type="hidden" name="id[entry_{{$entry['id']}}]" value="{{$entry['id']}}">
                @endforeach
                @if (count($participants) > 0)
                    <div id="slidemeister-competition-participants" class="slidemeister-instance"></div>
                    <div id="slidemeister-competition-participants-preview" class="slidemeister-instance"></div>
                    <div id="slidemeister-competition-participants-final" class="slidemeister-instance"></div>
                    <input type="hidden" name="slide[participants]">
                    <input type="hidden" name="preview[participants]">
                    <input type="hidden" name="final[participants]">
                    <input type="hidden" name="type[participants]" value="participants">
                    <input type="hidden" name="name[participants]" value="Participants">
                @endif
                <div id="slidemeister-competition-end" class="slidemeister-instance"></div>
                <div id="slidemeister-competition-end-preview" class="slidemeister-instance"></div>
                <div id="slidemeister-competition-end-final" class="slidemeister-instance"></div>
                <input type="hidden" name="slide[end]">
                <input type="hidden" name="preview[end]">
                <input type="hidden" name="final[end]">
                <input type="hidden" name="type[end]" value="end">
                <input type="hidden" name="name[end]" value="End">
            </div>
        </div>
    </form>
@endsection

@section('view_scripts')
    @include('partymeister-slides::layouts.partials.slide_scripts')
    <script>
        $(document).ready(function () {

            var sm = [];
            var preview_slides = [];
            var final_slides = [];
            sm['comingup'] = $('#slidemeister-competition-comingup').slidemeister('#slidemeister-properties', slidemeisterProperties);
            sm['comingup'].data.load({!! $comingupTemplate->definitions !!}, {
                'competition': '{{strtoupper($competition->name)}}',
                'headline': 'COMING UP'
            }, false, true);

            preview_slides['comingup'] = $('#slidemeister-competition-comingup-preview').slidemeister('#slidemeister-properties', slidemeisterProperties);
            preview_slides['comingup'].data.load({!! $comingupTemplate->definitions !!}, {
                'competition': '{{strtoupper($competition->name)}}',
                'headline': 'COMING UP'
            }, false, true);

            final_slides['comingup'] = $('#slidemeister-competition-comingup-final').slidemeister('#slidemeister-properties', slidemeisterProperties);
            final_slides['comingup'].data.load({!! $comingupTemplate->definitions !!}, {
                'competition': '{{strtoupper($competition->name)}}',
                'headline': 'COMING UP'
            }, false, true);


            sm['now'] = $('#slidemeister-competition-now').slidemeister('#slidemeister-properties', slidemeisterProperties);
            sm['now'].data.load({!! $comingupTemplate->definitions !!}, {
                'competition': '{{strtoupper($competition->name)}}',
                'headline': 'NOW'
            }, false, true);

            preview_slides['now'] = $('#slidemeister-competition-now-preview').slidemeister('#slidemeister-properties', slidemeisterProperties);
            preview_slides['now'].data.load({!! $comingupTemplate->definitions !!}, {
                'competition': '{{strtoupper($competition->name)}}',
                'headline': 'NOW'
            }, false, true);

            final_slides['now'] = $('#slidemeister-competition-now-final').slidemeister('#slidemeister-properties', slidemeisterProperties);
            final_slides['now'].data.load({!! $comingupTemplate->definitions !!}, {
                'competition': '{{strtoupper($competition->name)}}',
                'headline': 'NOW'
            }, false, true);
            @foreach($entries as $entry)
                sm['entry_{{$entry['id']}}'] = $('#slidemeister-entry-{{$entry['id']}}').slidemeister('#slidemeister-properties', slidemeisterProperties);
            sm['entry_{{$entry['id']}}'].data.load({!! $entryTemplate->definitions !!}, {!! json_encode($entry) !!}, false, true);

            preview_slides['entry_{{$entry['id']}}'] = $('#slidemeister-entry-{{$entry['id']}}-preview').slidemeister('#slidemeister-properties', slidemeisterProperties);
            preview_slides['entry_{{$entry['id']}}'].data.load({!! $entryTemplate->definitions !!}, {!! json_encode($entry) !!}, false, true);

            final_slides['entry_{{$entry['id']}}'] = $('#slidemeister-entry-{{$entry['id']}}-final').slidemeister('#slidemeister-properties', slidemeisterProperties);
            final_slides['entry_{{$entry['id']}}'].data.load({!! $entryTemplate->definitions !!}, {!! json_encode($entry) !!}, false, true);
            @endforeach
                    @if (count($participants) > 0)
                sm['participants'] = $('#slidemeister-competition-participants').slidemeister('#slidemeister-properties', slidemeisterProperties);
            sm['participants'].data.load({!! $participantsTemplate->definitions !!}, {
                'competition': 'PARTICIPANTS',
                'headline': '{{strtoupper($competition->name)}}',
                'body': '{{implode(', ', $participants)}}'
            }, false, true);

            preview_slides['participants'] = $('#slidemeister-competition-participants-final').slidemeister('#slidemeister-properties', slidemeisterProperties);
            preview_slides['participants'].data.load({!! $participantsTemplate->definitions !!}, {
                'competition': 'PARTICIPANTS',
                'headline': '{{strtoupper($competition->name)}}',
                'body': '{{implode(', ', $participants)}}'
            }, false, true);

            final_slides['participants'] = $('#slidemeister-competition-participants-final').slidemeister('#slidemeister-properties', slidemeisterProperties);
            final_slides['participants'].data.load({!! $participantsTemplate->definitions !!}, {
                'competition': 'PARTICIPANTS',
                'headline': '{{strtoupper($competition->name)}}',
                'body': '{{implode(', ', $participants)}}'
            }, false, true);
            @endif
                sm['end'] = $('#slidemeister-competition-end').slidemeister('#slidemeister-properties', slidemeisterProperties);
            sm['end'].data.load({!! $endTemplate->definitions !!}, {
                'competition': '{{strtoupper($competition->name)}}',
                'headline': 'END'
            }, false, true);

            preview_slides['end'] = $('#slidemeister-competition-end-preview').slidemeister('#slidemeister-properties', slidemeisterProperties);
            preview_slides['end'].data.load({!! $endTemplate->definitions !!}, {
                'competition': '{{strtoupper($competition->name)}}',
                'headline': 'END'
            }, false, true);

            final_slides['end'] = $('#slidemeister-competition-end-final').slidemeister('#slidemeister-properties', slidemeisterProperties);
            final_slides['end'].data.load({!! $endTemplate->definitions !!}, {
                'competition': '{{strtoupper($competition->name)}}',
                'headline': 'END'
            }, false, true);
            $('.competition-playlist-save').on('click', function (e) {

                var tasks = [];
                Object.keys(sm).forEach(function (key) {
                    $('input[name="slide[' + key + ']"]').val(JSON.stringify(sm[key].data.save(true)));

                    tasks.push(final_slides[key].data.export('final', key));
                    tasks.push(preview_slides[key].data.export('preview', key));

                    // tasks.push(sm[key].data.export('preview', key));
                    // tasks.push(sm[key].data.export('final', key));

                    //     Promise.all([
                    //         sm[key].data.export('preview').then(function(data) {
                    //             $('input[name="preview[' + key + ']"]').val(data);
                    //         }),
                    //         sm[key].data.export('final').then(function(data) {
                    //             $('input[name="final[' + key + ']"]').val(data);
                    //         })
                    // ]).then(function() {
                    //         $('form#competition-playlist-save').submit();
                    //     });

                });

                workMyCollection(tasks)
                    .then(() => {
                        for (let r of final) {
                            $('input[name="' + r[0] + '[' + r[1] + ']"]').val(r[2]);
                        }
                        $('form#competition-playlist-save').submit();
                    });
                return;

            });

            function asyncFunc(e) {
                return new Promise((resolve, reject) => {
                    setTimeout(() => resolve(e), e * 1000);
                });
            }

            let final = [];

            function workMyCollection(arr) {
                return arr.reduce((promise, item) => {
                    return promise
                        .then((result) => {
                            // console.log(result);
                            // console.log(`item ${item}`);
                            return asyncFunc(item).then(result => final.push(result));
                        })
                        .catch(console.error);
                }, Promise.resolve());
            }

        });
    </script>
@append
