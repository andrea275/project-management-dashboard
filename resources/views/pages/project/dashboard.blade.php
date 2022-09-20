@extends('layouts.main')

@section('content')
    <Dashboard project-slug="{{ $project->slug }}"></Dashboard>
@endsection
