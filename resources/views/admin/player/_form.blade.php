<div class="form-group, col-md-11">
    {!! Form::label('name', trans('player.name'), ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'autofocus']) !!}
</div>

<div class="form-group, col-md-11">
    {!! Form::label('birthday', trans('player.birthday'), ['class' => 'control-label']) !!}
    {!! Form::date('birthday', null, ['class' => 'form-control', 'autofocus']) !!}
</div>

<div class="form-group, col-md-11">
    {!! Form::label('team_id', trans('player.team'), ['class' => 'control-label']) !!}
    {!! Form::select('team_id', $teams, null, ['class' => 'form-control', 'autofocus', 'placeholder' => trans('common.choose')]) !!}
</div>

<div class="form-group, col-md-11">
    {!! Form::label('position_id', trans('player.position'), ['class' => 'control-label']) !!}
    {!! Form::select('position_id', $positions, null, ['class' => 'form-control', 'autofocus', 'placeholder' => trans('common.choose')]) !!}
</div>

<div class="form-group, col-md-11">
    {!! Form::label('country_id', trans('player.country'), ['class' => 'control-label']) !!}
    {!! Form::select('country_id', $countries, null, ['class' => 'form-control', 'autofocus', 'placeholder' => trans('common.choose')]) !!}
</div>
