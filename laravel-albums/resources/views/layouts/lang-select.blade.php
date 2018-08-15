<br>
Locale: {{ App::getLocale() }}
<br>
Browser Locale: {{ Request::server('HTTP_ACCEPT_LANGUAGE') }}
<br>
<select name="locale" id="locale">
    @foreach(LaravelLocalization::getSupportedLocales() as $key => $locale)
        <option value="{{ $key }}">{{ $key }}</option>
    @endforeach
</select>
