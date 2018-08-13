@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Seção Motion</h1>
        <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="">
            @lang('add')
        </a>
        <br>
        Locale: {{ App::getLocale() }}
        <br>
        Browser Locale: {{ Request::server('HTTP_ACCEPT_LANGUAGE') }}
        <br>
        <select name="locale" id="locale">
            @foreach(LaravelLocalization::getSupportedLocales() as $key => $locale)
                <option value="{{ $key }}">{{ $key }}</option>
            @endforeach
        </select>
    </section>
    <div class="content" style="min-height:800px">
        <div class="clearfix"></div>
        <div class="row">
        <table class="table table-responsive" id="categorias-table">
            <thead>
                <tr>
                    <th>@lang('name')</th>
                    <th>@lang('image')</th>
                    <th>@lang('genre')</th>
                    <th>@lang('description')</th>
                    <th colspan="3">@lang('actions')</th>
                </tr>
            </thead>
            <tbody>
            @foreach($artists as $artist)
                <tr>
                    <td>{!! $artist->name !!}</td>
                    <td>{!! $artist->image !!}</td>
                    <td>{!! $artist->genre !!}</td>
                    <td>{!! $artist->description !!}</td>
                    <td>
                        {!! Form::open(['route' => ['artist.destroy', $categoria->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{!! route('artist.show', [$categoria->id]) !!}" class='btn btn-default btn-xs'>
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a>
                            <a href="{!! route('artist.edit', [$categoria->id]) !!}" class='btn btn-default btn-xs'>
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                            {!! Form::button(
                                '<i class="glyphicon glyphicon-trash"></i>',
                                [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'onclick' => "return confirm('Are you sure?')"
                                ])
                            !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
@endsection
