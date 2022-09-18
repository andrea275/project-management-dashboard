@extends('layouts.main')

@section('content')
    <Project project-slug="{{ $project->slug }}"></Project>
@endsection
