@extends('layouts.main')

@section('content')
    <stock-list :stocks='@json($stocks)'></stock-list>
@endsection
