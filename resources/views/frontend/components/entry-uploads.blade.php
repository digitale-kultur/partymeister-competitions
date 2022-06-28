<div class="component-entry-upload">
    <h4>Upload entry</h4>
    @include('motor-backend::errors.list')
    {!! form_start($entryUploadForm) !!}
    <div class="@boxWrapper box-primary">
        <div class="@boxHeader with-border">
            <h3 class="box-title">{{ trans('motor-backend::backend/global.base_info') }}</h3>
        </div>
        <div class="@boxBody">
            {!! form_row($entryUploadForm->reload_on_change) !!}
            @if ($entryUploadForm->getModel())
                {!! form_label($entryUploadForm->competition_id) !!}
                <p>
                    {{$record->competition->name}}
                </p>
            @else
                {!! form_row($entryUploadForm->competition_id) !!}
            @endif
            @if (old($entryUploadForm->getName().'.competition_id') || (isset($entryUploadForm->getModel()[$entryUploadForm->getName()]) && $entryUploadForm->getModel()[$entryUploadForm->getName()]['competition_id'] > 0))
                {!! form_row($entryUploadForm->author) !!}
                {!! form_row($entryUploadForm->title) !!}
            @endif
        </div>
        <!-- /.box-body -->
    </div>
    @if (old($entryUploadForm->getName().'.competition_id') || (isset($entryUploadForm->getModel()[$entryUploadForm->getName()]) && $entryUploadForm->getModel()[$entryUploadForm->getName()]['competition_id'] > 0))
        <div class="@boxWrapper box-primary">
            <div class="@boxHeader with-border">
                <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.entry_info') }}</h3>
            </div>
            <div class="@boxBody">
                {!! form_row($entryUploadForm->description) !!}
                {!! form_row($entryUploadForm->organizer_description) !!}
                {!! form_row($entryUploadForm->discord_name) !!}
                @if ($entryUploadForm->has('running_time'))
                    {!! form_row($entryUploadForm->running_time) !!}
                @endif
            </div>
            <!-- /.box-body -->
        </div>
        <div class="@boxWrapper box-primary">
            <div class="@boxHeader with-border">
                <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.option_info') }}</h3>
            </div>
            <div class="@boxBody">
                {!! form_row($entryUploadForm->options) !!}
                {!! form_row($entryUploadForm->custom_option) !!}
            </div>
            <!-- /.box-body -->
        </div>

        <div class="@boxWrapper box-primary">
            <div class="@boxHeader with-border">
                <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.file_info') }} (LIMIT: 2048 MB)</h3>
            </div>
            <div class="@boxBody">
                <div class="row">
                    @if ($entryUploadForm->has('screenshot'))
                        <div class="col-md-3">
                            {!! form_row($entryUploadForm->screenshot) !!}
                        </div>
                    @endif
                    @if ($entryUploadForm->has('audio'))
                        <div class="col-md-3">
                            {!! form_row($entryUploadForm->audio) !!}
                        </div>
                    @endif
                    @if ($entryUploadForm->has('video'))
                        <div class="col-md-3">
                            {!! form_row($entryUploadForm->video) !!}
                        </div>
                    @endif
                        @if ($entryUploadForm->has('config_file'))
                            <div class="col-md-3">
                                {!! form_row($entryUploadForm->config_file) !!}
                            </div>
                        @endif
                </div>

                @if ($entryUploadForm->has('work_stage_1'))
                    <div class="row">

                        @php
                            $i = 1;
                        @endphp
                        @while ($entryUploadForm->has('work_stage_'.$i))
                            <div class="col-md-6">
                                {!! form_row($entryUploadForm->{'work_stage_'.$i}) !!}
                            </div>
                            @php
                                $i++;
                            @endphp
                        @endwhile
                    </div>
                @endif

                {!! form_row($entryUploadForm->file) !!}
            </div>
            <!-- /.box-body -->
        </div>
        <div class="@boxWrapper box-primary">
            <div class="@boxHeader with-border">
                <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.author_info') }}</h3>
            </div>
            <div class="@boxBody">
                {!! form_row($entryUploadForm->author_name) !!}
                {!! form_row($entryUploadForm->author_email) !!}
                {!! form_row($entryUploadForm->author_phone) !!}
                {!! form_row($entryUploadForm->author_address) !!}
                {!! form_row($entryUploadForm->author_zip) !!}
                {!! form_row($entryUploadForm->author_city) !!}
                {!! form_row($entryUploadForm->author_country_iso_3166_1) !!}
            </div>
            <!-- /.box-body -->
        </div>
        @if ($entryUploadForm->has('composer_name'))
            <div class="@boxWrapper box-primary">
                <div class="@boxHeader with-border">
                    <h3 class="box-title">
                        <button type="button" class="success button small float-right copy-data">Copy author data</button>
                        {{ trans('partymeister-competitions::backend/entries.composer_info') }}
                    </h3>
                </div>
                <div class="@boxBody">
                    {!! form_row($entryUploadForm->composer_name) !!}
                    {!! form_row($entryUploadForm->composer_email) !!}
                    {!! form_row($entryUploadForm->composer_phone) !!}
                    {!! form_row($entryUploadForm->composer_address) !!}
                    {!! form_row($entryUploadForm->composer_zip) !!}
                    {!! form_row($entryUploadForm->composer_city) !!}
                    {!! form_row($entryUploadForm->composer_country_iso_3166_1) !!}
                </div>
                <!-- /.box-body -->
            </div>
        @endif
        <div class="@boxWrapper box-primary">
            <div class="@boxHeader with-border">
                <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.notify_about_status') }}</h3>
            </div>
            <div class="@boxBody">
                <p>
                    Be aware that we have competitions which involve jury preselection, mostly - but not limited to - individual competitions such as music or graphics.
                </p>
                <p>
                    In case that your entry misses preselection, you can opt-in to receive an email with that information directly before the competition is shown.
                </p>

                {!! form_row($entryUploadForm->notify_about_status) !!}
            </div>
            @if ($visitor->is_remote)
            <div class="@boxHeader with-border">
                <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.remote_participation') }}</h3>
            </div>
            <div class="@boxBody">
                <p>
                    In order to avoid having an empty stage in case your entry ranks among the top three of this competition, we ask you kindly to name a
                    representative at the party location. This can be a group member, a friend or a kind soul that accepts the prize in your stead.
                </p>
                <p>
                    If you have no way of having somebody represent you, please enter "organizer". That way, we know that we don't have to wait for somebody
                    to show up on stage <3
                </p>
                {!! form_row($entryUploadForm->representative) !!}
            </div>
            @endif
        </div>
        <div class="@boxWrapper">
            <div class="@boxFooter">
                {!! form_row($entryUploadForm->submit) !!}
            </div>
        </div>
    @endif
    {!! form_end($entryUploadForm, false) !!}
</div>
@section('view-scripts')
    <script type="text/javascript">
        $('.reload-on-change').change(function (e) {
            $('#reload_on_change').val(1);
            $(this).closest('form').submit();
        });
        $('#reload_on_change').val('');

        $('.copy-data').on('click', function (e) {
            e.preventDefault();
            console.log($('input[name="entry-upload[composer_name]"]'));
            $('input[name="entry-upload[composer_name]"]').val($('input[name="entry-upload[author_name]"]').val());
            $('input[name="entry-upload[composer_email]"]').val($('input[name="entry-upload[author_email]"]').val());
            $('input[name="entry-upload[composer_phone]"]').val($('input[name="entry-upload[author_phone]"]').val());
            $('input[name="entry-upload[composer_address]"]').val($('input[name="entry-upload[author_address]"]').val());
            $('input[name="entry-upload[composer_zip]"]').val($('input[name="entry-upload[author_zip]"]').val());
            $('input[name="entry-upload[composer_city]"]').val($('input[name="entry-upload[author_city]"]').val());
            $('input[name="entry-upload[composer_country_iso_3166_1]"]').val($('input[name="entry-upload[author_country_iso_3166_1]"]').val());
        });

        $("input").keypress(function (e) {
            if (e.which == 13) {
                e.preventDefault();
            }
        });
    </script>
@append
