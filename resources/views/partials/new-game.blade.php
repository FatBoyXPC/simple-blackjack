<form method="POST" action="{{ route('games.store') }}">
    @csrf
    <button type="submit">New Game!</button>
</form>
