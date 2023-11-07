@extends('frontend.layouts.master')

@section('meta_title', $page->title)
@section('meta_description', $page->short_description)

@section('header_classes', $page->header_white ? 'header-white' : '')

@push('page_css')
    <style>
        {!! $page->css !!}
    </style>
@endpush

@section('page')
    {!! $page->html !!}
@endsection



