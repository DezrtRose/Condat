<div class="active tab-pane" id="activity">
    <!-- Post -->
    <div>
        {!! Form::open(['url' => 'tenant/clients/'.$client->client_id.'/notes', 'method' => 'post']) !!}
        <div class="col-sm-10">
            <input type="hidden" value=1 name="timeline" />
            <input name="description" class="form-control input-sm" type="text" placeholder="Type a Comment">
        </div>
        <div class="col-sm-2">
            <input type="submit" value="Submit" class="btn btn-primary btn-sm" />
        </div>
        <div>&nbsp;</div>
        {!! Form::close() !!}
    </div>
    <!-- /.post -->
</div>

{{-- The actual timeline --}}
<ul class="timeline timeline-inverse">
    <!-- timeline time label -->
    @foreach($timelines as $key => $grouped_timeline)
        <li class="time-label">
            <span class="bg-red">
              {{ readable_date($key) }}
            </span>
        </li>
        <!-- /.timeline-label -->
        <!-- timeline item -->
        @foreach($grouped_timeline as $timeline)
            <li>
                <i class="fa {{$timeline->image}}"></i>

                <div class="timeline-item">
                                        <span class="time"><i
                                                    class="fa fa-clock-o"></i> {{get_datetime_diff($timeline->created_at)}}</span>
                    {!! $timeline->message !!}
                </div>
            </li>
        @endforeach
    @endforeach
    <li>
        <i class="fa fa-clock-o bg-gray"></i>
    </li>
</ul>

{{--<div class="scroll">
    @foreach($timeline_list as $key => $grouped_timeline)
        <li class="time-label">
            <span class="bg-red">
              {{ readable_date($key) }}
            </span>
        </li>
        <!-- /.timeline-label -->
        <!-- timeline item -->
        @foreach($grouped_timeline as $timeline)
            <li>
                <i class="fa {{$timeline->image}}"></i>

                <div class="timeline-item">
                                        <span class="time"><i
                                                    class="fa fa-clock-o"></i> {{get_datetime_diff($timeline->created_at)}}</span>
                    {!! $timeline->message !!}
                </div>
            </li>
        @endforeach
    @endforeach
</div>--}}

{{ Condat::js('assets/plugins/jScroll/jquery.jscroll.js') }}

<script type="text/javascript">
    $(document).ready(function () {
        $('.scroll').jscroll({
            loadingHtml: '<img src="loading.gif" alt="Loading" /> Loading...',
            //padding: 20,
            //nextSelector: 'a.jscroll-next:last',
            //contentSelector: 'li'
        });
    })
</script>