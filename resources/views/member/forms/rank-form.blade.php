@include('application.partials.errors')
<form action="{{ route('member.rank.update', $member->getUrlParams()) }}" method="post">
    {{ csrf_field() }}
    <div class="panel panel-filled">
        <div class="panel-heading panel-b-accent">
            <strong class="c-white">Update Rank</strong>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="rank">New rank</label>
                        <select name="rank" id="rank" class="form-control">
                            @foreach ($ranks as $rank)
                                <option value="{{ $rank->id }}">{{ $rank->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    {!! Form::label('created_at', 'Effective date') !!} <span
                        class="text-accent">*</span>
                    {{ Form::date('created_at', now(), ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>

            <div class="form-group">
                <input type="checkbox" name="historical" id="historical">
                <label for="historical">Historical entry?</label>
                <p class="help-text">Enabling this will leave the member's current rank intact.</p>
            </div>

        </div>

        <div class="panel-footer text-right">
            <button class="btn btn-default" type="submit">Submit</button>
        </div>
    </div>

</form>
