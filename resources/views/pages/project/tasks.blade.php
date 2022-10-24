@extends('layouts.project')

@section('content')
    <Tasks project-slug="{{ $project->slug }}"></Tasks>
@endsection
