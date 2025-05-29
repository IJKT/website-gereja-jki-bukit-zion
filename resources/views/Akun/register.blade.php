<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body style="font-family: 'Kantumruy Pro', sans-serif;">
    <div>
        {{-- BG IMG --}}
        <img src="pics/background.png" class="fixed inset-0 w-full h-full object-cover filter blur-xs"
            style="z-index: -1;">

        {{-- register form --}}
        {{-- 
        TODO: jadiin indonesia --}}
        <div class="h-screen w-6/11 bg-[#D9D9D9] shadow-md rounded-r-lg p-12 flex flex-col justify-center">
            <div class="items-center justify-center">
                <img src="pics/logo_pic.png" class="w-[70px] h-[70px] mx-auto">
                <h1 class="text-3xl font-extrabold text-center mb-5">DAFTAR AKUN</h1>
            </div>
            <form {{-- action="{{ route('login') }}" method="post" class="flex flex-col gap-4 mt-8" --}}>
                @csrf
                <div class="flex justify-between gap-4">
                    {{-- left side --}}
                    <div class="flex flex-col w-1/2 space-y-2">
                        <label for="username" class="font-semibold mb-1">Username</label>
                        <input type="text" name="username" id="username" placeholder="Insert your username"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]" required
                            oninvalid="this.setCustomValidity('Username is required')"
                            oninput="this.setCustomValidity('')">

                        <label for="username" class="font-semibold mb-1">Password</label>
                        <input type="password" name="password" id="password" placeholder="Insert your password"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]" required
                            oninvalid="this.setCustomValidity('Password is required')"
                            oninput="this.setCustomValidity('')">

                        <label for="fullname" class="font-semibold mb-1">Full Name</label>
                        <input type="text" name="fullname" id="fullname" placeholder="Insert your full name"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]" required
                            oninvalid="this.setCustomValidity('Full name is required')"
                            oninput="this.setCustomValidity('')">

                        <label for="nik" class="font-semibold mb-1">NIK
                        </label>
                        <input type="number" name="nik" id="nik" placeholder="Insert your NIK"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]" required
                            oninvalid="this.setCustomValidity('NIK is required')" oninput="this.setCustomValidity('')">

                        <div>
                            <label class="font-semibold mb-2 block">Place & Date Of Birth</label>
                            <div class="flex justify-between gap-[10px]">
                                <input type="text" name="birthcity" id="birthcity" placeholder="Birth city"
                                    class="p-2 rounded-md w-1/2 border-2 border-white bg-white focus:border-[#215773]">
                                <input type="date" name="birthdate" id="birthdate"
                                    class="p-2 rounded-md w-1/2 border-2 border-white bg-white focus:border-[#215773]"
                                    max="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    {{-- right side --}}
                    <div class="flex flex-col w-1/2 space-y-2">
                        <label for="email" class="font-semibold mb-1">Email</label>
                        <input type="email" name="email" id="email" placeholder="Insert your email"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]" required
                            oninvalid="this.setCustomValidity('Email is required')"
                            oninput="this.setCustomValidity('')">

                        <label for="username" class="font-semibold mb-1">Confirm Password</label>
                        <input type="password" name="confpassword" id="confpassword" placeholder="Confirm your password"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]" required
                            oninvalid="this.setCustomValidity('Password confirmation is required')"
                            oninput="this.setCustomValidity('')">

                        <label for="homeaddress" class="font-semibold mb-1">Home Address</label>
                        <input type="text" name="homeaddress" id="homeaddress" placeholder="Insert your home address"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]" required
                            oninvalid="this.setCustomValidity('Home address is required')"
                            oninput="this.setCustomValidity('')">
                        {{-- onchange="if(!this.value) {window.open('www.google.com/maps', '_blank');}"> --}}

                        <label for="phone" class="font-semibold mb-1">Phone Number</label>
                        <input type="number" name="phone" id="phone" placeholder="Insert your phone number"
                            class="p-2 rounded-md border-2 border-white bg-white focus:border-[#215773]" required
                            oninvalid="this.setCustomValidity('Phone number is required')"
                            oninput="this.setCustomValidity('')">

                        {{-- <div>
                            <label class="font-semibold mb-2 block">Gender</label>
                            <div class="flex justify-between gap-[10px]">
                                <input type="text" name="birthcity" id="birthcity" placeholder="Birth city"
                                    class="p-2 rounded-md w-1/2 border-2 border-white bg-white focus:border-[#215773]">
                                <input type="date" name="birthdate" id="birthdate"
                                    class="p-2 rounded-md w-1/2 border-2 border-white bg-white focus:border-[#215773]"
                                    max="{{ date('Y-m-d') }}">
                            </div>
                        </div> --}}

                        <div class="mb-4" x-data="{ gender: '' }">
                            <label class="font-semibold block mb-4">Gender</label>
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="gender" @click="gender = 'male'"
                                        @click=class="form-radio text-[#215773]">
                                    <span :class="gender == 'male' ? 'font-semibold' : 'font-normal'">Male</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="gender" @click="gender = 'female'"
                                        class="form-radio text-[#215773]">
                                    <span :class="gender == 'female' ? 'font-semibold' : 'font-normal'">Female</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center">
                    {{-- <button type="submit" class="w-1/5 p-2 rounded-md bg-[#215773] hover:bg-[#2f4957] mt-5 text-white font-bold">REGISTER</button> --}}
                </div>
            </form>
            <button type="submit"
                class="w-1/5 p-2 rounded-md bg-[#215773] hover:bg-[#2f4957] mt-5 text-white font-bold"
                onclick="window.location.href='/login'">REGISTER</button>
        </div>
    </div>
</body>

</html>
