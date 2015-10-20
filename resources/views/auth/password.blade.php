<form method="POST" action="/password/email">
    {!! csrf_field() !!}

    @include('auth.partials.errors')

    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        <button type="submit">
            Send Password Reset Link
        </button>
    </div>
</form>