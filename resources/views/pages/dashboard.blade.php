@extends("layouts.main")
@section("content")

@php
    date_default_timezone_set('Asia/Jakarta');
    $hour = now()->format('H');
    if ($hour >= 5 && $hour < 12) {
        $greeting = 'Selamat pagi';
    } elseif ($hour >= 12 && $hour < 15) {
        $greeting = 'Selamat siang';
    } elseif ($hour >= 15 && $hour < 18) {
        $greeting = 'Selamat sore';
    } else {
        $greeting = 'Selamat malam';
    }
@endphp

<div class="p-4 sm:ml-64 mt-10">
    <div class="p-4 flex justify-between">
        <h6>{{ $greeting }}, <span class="font-semibold" id="user-nama"></span>!</h6>
        <div class="flex justify-center items-center bg-blue-50 p-1 rounded-sm shadow-md mr-2">
            <h6 id="live-time" class="text-blue-500 font-semibold text-sm tracking-wide"></h6>
        </div>
    </div>
</div>

@endsection
@push("js")
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('user-nama').innerHTML = Store.getCurrentUser().nama;

            function updateTime() {
                const now = new Date();
                const pad = n => n.toString().padStart(2, '0');
                const formatted = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
                document.getElementById('live-time').textContent = formatted;
            }

            updateTime();
            setInterval(updateTime, 1000);
        })
    </script>
@endpush