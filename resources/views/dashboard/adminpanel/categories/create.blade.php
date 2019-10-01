@extends('dashboard.layouts.app')

@section('title', "Создание категории")

@section('content')

    <div class="row searchform_breadcrumbs">
        <div class="col-xs-12 col-sm-12 col-md-9 breadcrumbs">
            {{ Breadcrumbs::render('categories.create') }}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 d-none d-md-block searchform">{{-- d-none d-md-block - Скрыто на экранах меньше md --}}
            @include('layouts.partials.searchform')
        </div>
    </div>


    <h1>Создание категории</h1>


    <div class="row">

        
        @include('dashboard.layouts.partials.aside')


        <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                
            <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- image --}}
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card-img-top b_image" style="background-image: url({{ asset('storage') }}{{ config('imageyo.default_img') }});">
                            <div class="dummy"></div><div class="element"></div>
                        </div>
                    </div>

                    <div class="col-sm-9">
                        @lfmImageButton(['id' => 'lfm_category_new', 'name' => 'imagepath', 'value' => old('imagepath')])
                    </div>
                </div>
                {{-- /image --}}
                

                <div class="row">
                    {{-- name --}}
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="name">{{ __('name') }}</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Name Product"
                                value="{{ old('name') }}" required>
                        </div>
                    </div>
                    {{-- /name --}}

                    {{-- title --}}
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="title">{{ __('title') }}</label>
                            <input type="text" id="title" name="title" class="form-control" placeholder="Name Product"
                                value="{{ old('title') }}" required>
                        </div>
                    </div>
                    {{-- /title --}}
                </div>

                <div class="form-group">
                    <label for="description">{{ __('description') }}</label>
                    <textarea id="description" name="description" cols="30" rows="4" class="form-control"
                        placeholder="description">{{ old('description') }}</textarea>                       
                </div>


                <div class="row">
                    {{-- sort_order --}}
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="sort_order">{{ __('sort_order') }}</label>
                            <select name="sort_order" id="sort_order">
                                @for ( $i = 0; $i < 10; $i++ )
                                    @if ( 5 == $i )
                                        <option value="{{ $i }}" selected>{{ $i }}</option>
                                    @else
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>
                    {{-- sort_order --}}

                    {{-- parent category --}}
                    <div class="col-12 col-md-5">
                        <div class="form-group">
                            <label for="description">{{ __('category') }}</label>
                            <select name="parent_id" id="parent_id">
                                @foreach ( $categories as $parent_category )
                                    @if ( !$parent_category->countProducts() )
                                        <option value="{{ $parent_category->id }}">{{ $parent_category->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- /parent category --}}

                    {{-- visible --}}
                    <div class="form-group right_stylized_checkbox col-12 col-md-4">
                        <input type="checkbox" id="visible" name="visible" checked>
                        <label for="visible">{{ __('visible') }}</label>
                    </div>
                    {{-- /visible --}}
                </div>

                <button type="submit" class="btn btn-primary form-control">{{ __('apply') }}</button>

            </form>
        </div>
    </div>
@endsection
