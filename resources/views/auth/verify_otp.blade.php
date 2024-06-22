@extends('layouts.nav')

@section('content')
    <div class="register_form mx-auto mt-10 p-10 bg-blue-400  w-1/3">
        <p>
            @if (session()->has('status'))
                {{ session()->get('otp_email') }}
                <div class="text-red-600 font-bold">{{ session()->get('status') }}</div>
            @endif
        </p>
        <p>
        <div class="text-red-600 otp_sent font-bold"></div>
        </p>
        <h1 class="text-3xl font-medium mb-2">Otp</h1>
        <form method="POST" class="w-full flex-wrap" action="{{ route('verify.otp') }}">
            @csrf
            <input autofocus class="w-full focus:outline-0 p-3" type="otp" placeholder="Enter Otp" id="otp"
                name="otp" required>
            <div class="mt-4 flex">
                <button class="bg-green-400 py-3 w-1/2  text-white" type="submit"> Submit</button>
                <button class="bg-green-400 py-3 w-1/2 ml-5 hidden text-white resendOtp" type="button"> Resend</button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $(".resendOtp").click(function() {
                $.ajax({
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content"),
                    },
                    data: {
                        data: "resendOtp",
                    },
                    url: "{{ route('resend.otp') }}",
                    success: function(success_data) {
                        $(".otp_sent").text("otp sent");
                        $(".resendOtp").addClass("hidden");
                    }
                });
            });
            setInterval(function() {
                $(".resendOtp").removeClass("hidden");
            }, 30000); //30 seconds
        });
    </script>
@endsection
