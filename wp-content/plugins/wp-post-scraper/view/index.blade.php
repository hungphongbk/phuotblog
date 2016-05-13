@extends('layout.base')
@section('content')
    <form class="form-crawl">
        <input type="hidden" name="action" value="{{ WPPostScraper::getAction('crawl') }}">
        <button type="submit">Crawl</button>
    </form>
@endsection