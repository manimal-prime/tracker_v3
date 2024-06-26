<div class="row">
    <div class="col-sm-6">
        <h4>{{ $division->locality('platoon') }} Details</h4>
        <p>Please provide the details for your {{ $division->locality('platoon') }}. Keep in mind the following when assigning a leader:</p>

        <p>Assigning a {{ $division->locality('platoon leader') }}</p>
        <ul>
            <li>
                <span class="text-success">DOES</span> move them to this {{ $division->locality('platoon') }}
            </li>

            <li>
                <span class="text-success">DOES</span> change their position to
                <code>{{ $division->locality('platoon leader') }}</code>
            </li>

            <li>
                <span class="text-success">DOES</span> remove them from any {{ $division->locality('squad') }} they may be in.
            </li>

            <br />
            <li><span class="text-danger">DOES NOT</span> change user account access</li>
        </ul>

    </div>

    <div class="col-sm-6">
        @include('application.partials.errors')

        <div class="panel panel-filled">
            <div class="panel-body">

                <div class="form-group {{ $errors->has('name') ? ' has-error' : null }}">
                    <label for="name" class="form-label">{{ $division->locality('platoon') }} Name</label>
                    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <div class="form-group {{ $errors->has('logo') ? ' has-error' : null }}">
                    <label for="logo" class="form-label">{{ $division->locality('platoon') }} Logo URL</label>
                    {!! Form::text('logo', null, ['class' => 'form-control', 'placeholder' => 'https://']) !!}
                </div>

                <div class="form-group">
                    <label for="order" class="form-label">{{ $division->locality('platoon') }} Sort Order</label>
                    {!! Form::number('order', isset($lastSort) ? $lastSort : null, ['class' => 'form-control']) !!}
                </div>

                <div class="row">
                    <div class="col-xs-8">
                        {!! Form::label('leader', 'Search') !!}
                        <input type="text" class="form-control search-member" name="leader" id="leader"
                               autocomplete="off" />
                        <i class="fa fa-search pull-right" style="position: absolute; right: 20px; top: 35px;"></i>
                        <div class="form-group m-t-md">
                            {!! Form::label('is_tba', 'Leader TBA') !!}
                            <div style="margin-right:5px;float: left;">
                                <input id="is_tba"
                                       type="checkbox" {{ (empty($platoon->leader_id)) ? "checked" : null }} />
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class="form-group {{ $errors->has('leader_id') ? ' has-error' : null }}">
                            {!! Form::label('leader_id', $division->locality('platoon leader') . ':') !!}
                            {!! Form::number('leader_id', null, ['class' => 'form-control'] ) !!}
                        </div>
                    </div>
                </div>

                <a href="{{ route('division', $division->slug) }}" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-success pull-right">Save</button>
            </div>
        </div>


    </div>
</div>

{{ csrf_field() }}

@section('footer_scripts')
    <script src="{!! asset('/js/platoon.js') !!}"></script>
@endsection