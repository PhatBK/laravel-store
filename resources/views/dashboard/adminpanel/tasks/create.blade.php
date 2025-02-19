@extends('layouts.theme_switch')

@section('title', 'Creating new task')

@section('content')

    <div class="row searchform_breadcrumbs">
        <div class="col-xs-12 col-sm-12 col-md-9 breadcrumbs">
            {{ Breadcrumbs::render('tasks.create', auth()->user()) }}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 d-none d-md-block searchform">{{-- d-none d-md-block - Скрыто на экранах меньше md --}}
            @include('layouts.partials.searchform')
        </div>
    </div>


    <h1>Creating new task</h1>


    <div class="row">


        @include('dashboard.layouts.partials.aside')


        <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">

            <form method="POST" action="{{ route('tasks.store') }}">

                @csrf

                <div class="form-group">
                    <label for="slave_user_id">Исполнитель</label>
                    <select name="slave_user_id" id="slave_user_id">
                        @foreach($slaves as $slave)
                            <option value="{{ $slave->id }}">{{ $slave->name }}</option>';
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="taskspriority_id">Приоритет</label>
                    <select name="taskspriority_id" id="taskspriority_id">
                        @foreach($taskspriorities as $tasksprioritie)
                            <option value="{{ $tasksprioritie->id }}">{{ $tasksprioritie->display_name }}</option>';
                        @endforeach
                    </select>
                </div>

                @input(['name' => 'name', 'value' => old('name'), 'required' => 'required'])

                @textarea(['name' => 'description', 'value' => old('description'), 'required' => 'required'])

                <button type="submit" class="btn btn-primary form-control">Create new task!</button>

            </form>
        </div>
    </div>
@endsection

