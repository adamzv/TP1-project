<p>Dobrý deň, </p>

@if ($subjectName == 'place')
    <p>Miesto konania udalosti <b>{{ $event->name }}</b> sa zmenilo!<br>
        Nové miesto konania udalosti je: <b>{{ $subjectValue }}</b>
    </p>
@elseif ($subjectName == 'delete')
    <p>Udalosť s názvom <b>{{ $event->name }}</b> ktorá sa mala konať {{ $subjectValue }}<br>
        bola <b>zrušená</b>.
    </p>
@elseif ($subjectName == 'beginning')
    <p>Čas konania udalosti <b>{{ $event->name  }}</b> sa zmenil!<br>
        Nový čas konania udalosti je: <b>{{ $subjectValue }}</b>
    </p>
@else
    <p>Miesto a čas konania udalosti <b>{{ $event->name  }}</b> sa zmenili!<br>
        Nové miesto konania udalosti je: <b>{{ $subjectValue }}</b>
        Nový čas konania udalosti je: <b>{{ $event->beginning }}</b>
@endif
