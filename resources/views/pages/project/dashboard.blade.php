@extends('layouts.project')

@section('content')
    <Dashboard project-slug="{{ $project->slug }}"></Dashboard>
@endsection
