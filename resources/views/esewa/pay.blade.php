@extends('layouts.app')

@section('title', 'Redirecting to eSewa…')

@section('content')
<div class="max-w-md mx-auto mt-24 p-10 bg-white shadow rounded-xl text-center">
    <h1 class="text-2xl font-semibold mb-4">Redirecting to eSewa</h1>
    <p class="text-gray-600 mb-6">Please wait while we transfer you to the secure payment page…</p>

    {{-- Build the form dynamically from the payload --}}
    <form id="esewaForm" action="{{ $payload['form_action'] }}" method="POST">
        @foreach($payload as $name => $value)
            @continue($name === 'form_action') {{-- not a field --}}
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endforeach
    </form>

    <button onclick="document.getElementById('esewaForm').submit()"
            class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium shadow">
        Pay {{ number_format($payload['total_amount'], 2) }} NPR
    </button>
</div>

<script>
    // auto‑submit after tiny delay
    setTimeout(() => document.getElementById('esewaForm').submit(), 1500);
</script>
@endsection
