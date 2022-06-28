@extends('motor-backend::layouts.backend')

@section('htmlheader_title')
    {{ trans('motor-backend::backend/global.home') }}
@endsection

@section('contentheader_title')
    {{ trans('partymeister-competitions::backend/votes.votes') }}
    @if (has_permission('votes.write'))
        {!! link_to_route('backend.votes.playlist.index', trans('partymeister-competitions::backend/votes.generate_prizegiving'), [], ['class' => 'float-right btn btn-sm btn-success']) !!}
        {!! link_to_route('backend.competition_prizes.create', trans('partymeister-competitions::backend/competition_prizes.edit'), [], ['class' => 'float-right btn btn-sm btn-success']) !!}
        {!! link_to_route('backend.votes.create', trans('partymeister-competitions::backend/votes.edit'), [], ['class' => 'float-right btn btn-sm btn-success']) !!}
        <div class="dropdown float-right">
            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{trans('partymeister-competitions::backend/competition_prizes.downloads')}}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                {!! link_to_route('backend.competition_prizes.export.receipt', trans('partymeister-competitions::backend/competition_prizes.empty_receipt'), [], ['class' => 'dropdown-item']) !!}
                {!! link_to_route('backend.competition_prizes.export.prizesheet', trans('partymeister-competitions::backend/competition_prizes.prizesheet'), ['prizesheet' => true, 'receipt' => true], ['class' => 'dropdown-item']) !!}
                {!! link_to_route('backend.competition_prizes.export.prizesheet', trans('partymeister-competitions::backend/competition_prizes.prizesheet_only'), ['prizesheet' => true], ['class' => 'dropdown-item']) !!}
                {!! link_to_route('backend.competition_prizes.export.prizesheet', trans('partymeister-competitions::backend/competition_prizes.receipts_only'), ['receipt' => true], ['class' => 'dropdown-item']) !!}
                {!! link_to_route('backend.competition_prizes.export.ascii', trans('partymeister-competitions::backend/competition_prizes.ascii_file'), ['ascii' => true], ['class' => 'dropdown-item']) !!}
            </div>
        </div>
    @endif
@endsection

@section('main-content')
    <div class="@boxWrapper">
        <div class="@boxHeader">
            <h3 class="box-title">@if($deadlineOver)<span style="color: red;">{{trans('partymeister-competitions::backend/votes.deadline_over')}}: @else {{trans('partymeister-competitions::backend/votes.deadline')}}: @endif {{config('partymeister-competitions-voting.deadline')}}@if($deadlineOver)</span>@endif </h3>
        </div>
    </div>
    <div class="@boxWrapper">
        @if (isset($special) && count($special) > 0)
        <div class="@boxHeader">
            <h3 class="box-title">Crowd favourite</h3>
        </div>
        <div class="@boxBody">
            @foreach ($special as $entry)
                <div class="row @if($entry['tie']) partymeister-tie @endif">
                    <div class="col-md-1">
                        {{number_format($entry['special_votes'], 0,',','')}}
                    </div>
                    <div class="col-md-3">
                        {{$entry['competition']}}
                    </div>
                    <div class="col-md-4">
                        {{$entry['title']}}
                    </div>
                    <div class="col-md-4">
                        {{$entry['author']}}
                    </div>
                </div>
            @endforeach
        </div>
        @endif
        @foreach ($results as $competition)
            <div class="@boxHeader">
                <h3 class="box-title">{{$competition['name']}}</h3>
            </div>
            <div class="@boxBody">
                @if (count($competition['entries']) === 0)
                    {{trans('partymeister-competitions::backend/votes.no_entries_for_this_competition')}}
                @else
                    @foreach ($competition['entries'] as $entry)
                        <div class="row @if($entry['tie']) partymeister-voting-tie @endif">
                            <div class="col-md-1">
                                #{{$entry['rank']}}
                            </div>
                            <div class="col-md-1">
                                {{number_format($entry['points'], 0,',','')}}
                            </div>
                            <div class="col-md-5">
                                {{$entry['title']}}
                            </div>
                            <div class="col-md-5">
                                {{$entry['author']}}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>
@endsection

@section('view_scripts')
    <script type="text/javascript">
        $('.delete-record').click(function (e) {
            if (!confirm('{{ trans('motor-backend::backend/global.delete_question') }}')) {
                e.preventDefault();
                return false;
            }
        });
    </script>
@append
