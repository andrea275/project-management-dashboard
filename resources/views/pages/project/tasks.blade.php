@extends('layouts.project')

@section('content')
    <Project project-slug="{{ $project->slug }}"></Project>
@endsection
