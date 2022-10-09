@extends('layouts.project')

@section('content')
    <Users project-slug="{{ $project->slug }}"></Users>
@endsection
