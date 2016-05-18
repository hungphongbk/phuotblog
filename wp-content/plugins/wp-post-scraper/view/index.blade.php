@extends('layout.base')
@section('content')
    <form class="form-crawl">
        <input type="hidden" name="action" value="{{ WPPostScraper::getAction('crawl') }}">
        <input type="radio" name="worker" value="start">Start
        <input type="radio" name="worker" value="stop">Stop
        <button type="submit">Crawl</button>
    </form>
@endsection