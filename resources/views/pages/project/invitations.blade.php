@extends('layouts.project')

@section('content')
    <Invitations project-slug="{{ $project->slug }}"></Invitations>
@endsection
