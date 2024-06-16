<ul>
    {{--  выводим значени таблицы typeresults --}}
    @foreach ($resultsArray as $result)
        {{ $result['updated_at']}}
            {{ $result['result'] }}
        <br>
    @endforeach
</ul>
