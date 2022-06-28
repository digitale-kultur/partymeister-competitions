{!! form_start($form) !!}
<div class="@boxWrapper box-primary">
    <div class="@boxHeader with-border">
        <h3 class="box-title">{{ trans('motor-backend::backend/global.base_info') }}</h3>
    </div>
    <div class="@boxBody">
        {!! form_row($form->reload_on_change) !!}
        {!! form_row($form->competition_id) !!}
        @if (old('competition_id') || (is_object($form->getModel()) && $form->getModel()->competition_id > 0))
            {!! form_row($form->author) !!}
            {!! form_row($form->title) !!}
            {!! form_row($form->sort_position) !!}
            {!! form_row($form->status) !!}
            {!! form_row($form->upload_enabled) !!}
        @endif
    </div>
    <!-- /.box-body -->
</div>
@if (old('competition_id') || (is_object($form->getModel()) && $form->getModel()->competition_id > 0))
    <div class="@boxWrapper box-primary">
        <div class="@boxHeader with-border">
            <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.entry_info') }}</h3>
        </div>
        <div class="@boxBody">
            {!! form_row($form->description) !!}
            {!! form_row($form->organizer_description) !!}
            @if ($form->has('running_time'))
                {!! form_row($form->running_time) !!}
            @endif
        </div>
        <!-- /.box-body -->
    </div>
    <div class="@boxWrapper box-primary">
        <div class="@boxHeader with-border">
            <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.option_info') }}</h3>
        </div>
        <div class="@boxBody">
            {!! form_row($form->options) !!}
            {!! form_row($form->custom_option) !!}
        </div>
        <!-- /.box-body -->
    </div>

    <div class="@boxWrapper box-primary">
        <div class="@boxHeader with-border">
            <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.file_info') }}</h3>
        </div>
        <div class="@boxBody">
            <div class="row">
                @if ($form->has('screenshot'))
                    <div class="col-md-3">
                        {!! form_row($form->screenshot) !!}
                    </div>
                @endif
                @if ($form->has('audio'))
                    <div class="col-md-3">
                        {!! form_row($form->audio) !!}
                    </div>
                @endif
                @if ($form->has('video'))
                    <div class="col-md-3">
                        {!! form_row($form->video) !!}
                    </div>
                @endif
            </div>

            @if ($form->has('work_stage_1'))
                <div class="row">

                @php
                    $i = 1;
                @endphp
                @while ($form->has('work_stage_'.$i))
                    <div class="col-md-3">
                        {!! form_row($form->{'work_stage_'.$i}) !!}
                    </div>
                    @php
                        $i++;
                    @endphp
                @endwhile
                </div>
            @endif

            {!! form_row($form->file) !!}
            @if ($form->has('config_file'))
                {!! form_row($form->config_file) !!}
            @endif
            {!! form_row($form->final_file_media_id) !!}
            {!! form_row($form->playable_file_id_1) !!}
            {!! form_row($form->playable_file_id_2) !!}
            {!! form_row($form->playable_file_id_3) !!}
            {!! form_row($form->playable_file_id_4) !!}
        </div>
        <!-- /.box-body -->
    </div>
    <div class="@boxWrapper box-primary">
        <div class="@boxHeader with-border">
            <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.additional_info') }}</h3>
        </div>
        <div class="@boxBody">
            <div class="row">
                <div class="col-md-3">
                    {!! form_row($form->allow_release) !!}
                </div>
                <div class="col-md-3">
                    {!! form_row($form->is_prepared) !!}
                </div>
                <div class="col-md-3">
                    {!! form_row($form->has_explicit_content) !!}
                </div>
                <div class="col-md-3">
                    {!! form_row($form->needs_content_check) !!}
                </div>
                @if ($form->has('is_remote'))
                    <div class="col-md-3">
                        {!! form_row($form->is_remote) !!}
                    </div>
                @endif
                @if ($form->has('is_recorded'))
                    <div class="col-md-3">
                        {!! form_row($form->is_recorded) !!}
                    </div>
                @endif
            </div>
            @if ($form->has('platform'))
                {!! form_row($form->platform) !!}
            @endif
            @if ($form->has('filesize'))
                {!! form_row($form->filesize) !!}
            @endif
        </div>
        <!-- /.box-body -->
    </div>
    <div class="@boxWrapper box-primary">
        <div class="@boxHeader with-border">
            <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.author_info') }}</h3>
        </div>
        <div class="@boxBody">
            {!! form_row($form->author_name) !!}
            {!! form_row($form->author_email) !!}
            {!! form_row($form->author_phone) !!}
            {!! form_row($form->author_address) !!}
            {!! form_row($form->author_zip) !!}
            {!! form_row($form->author_city) !!}
            {!! form_row($form->author_country_iso_3166_1) !!}
            {!! form_row($form->discord_name) !!}
        </div>
        <!-- /.box-body -->
    </div>
    @if ($form->has('composer_name'))
        <div class="@boxWrapper box-primary">
            <div class="@boxHeader with-border">
                <h3 class="box-title">{{ trans('partymeister-competitions::backend/entries.composer_info') }}</h3>
            </div>
            <div class="@boxBody">
                {!! form_row($form->composer_not_member_of_copyright_collective) !!}
                {!! form_row($form->composer_name) !!}
                {!! form_row($form->composer_email) !!}
                {!! form_row($form->composer_phone) !!}
                {!! form_row($form->composer_address) !!}
                {!! form_row($form->composer_zip) !!}
                {!! form_row($form->composer_city) !!}
                {!! form_row($form->composer_country_iso_3166_1) !!}
            </div>
            <!-- /.box-body -->
        </div>
    @endif
    <div class="@boxWrapper">
        <div class="@boxFooter">
            {!! form_row($form->submit) !!}
        </div>
    </div>

@endif
{!! form_end($form, false) !!}
@section('view_scripts')
    <script type="text/javascript">
        $('.reload-on-change').change(function (e) {
            $('#reload_on_change').val(1);
            $(this).closest('form').submit();
        });
        $('#reload_on_change').val('');
    </script>
@append
