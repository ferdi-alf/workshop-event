<div class="bg-white/35 backdrop-blur-xl scrollbar min-h-svh overflow-auto overflow-x-auto rounded-2xl shadow-xl p-3">
    <div class="shadow-sm  flex justify-evenly items-center rounded-xl backdrop-blur-2xl p-2">
        <img src="{{ asset('img/logo.png') }}" alt="logo" class="w-10 h-10 " />
        <h1 class="gradient-text font-extrabold">Workshop Event</h1>
    </div>
    <div class=" ">

        <ul class="mt-10 space-y-2 font-semibold">
            <x-sidebar-item href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="home" label="Dashboard" />

            <x-sidebar-item href="{{ route('user.index') }}" :active="request()->routeIs('user*')" icon="user" label="Users" />

            <x-sidebar-item href="{{ route('workshop.index') }}" :active="request()->routeIs('workshop*')" icon="calendar-days"
                label="Workshop" />

            <x-sidebar-item href="{{ route('banner.index') }}" :active="request()->routeIs('banner*')" icon="images" label="Banners" />

            <x-sidebar-item href="{{ route('feedback.index') }}" :active="request()->routeIs('feedback*')" icon="comments" label="Feedback" />

            <x-sidebar-item href="{{ route('participants.index') }}" :active="request()->routeIs('participants*')" icon="users"
                label="Participants" />
        </ul>

        <div class="shadow-lg p-3 mt-28 bg-white/20 rounded-xl">
            <h1 class="font-semibold  text-lg text-white">{{ Auth::user()->name }}</h1>
            <h1 class="font-extralight text-sm  text-white">{{ Auth::user()->email }}</h1>
            <x-sidebar-item href="{{ route('profile.edit') }}" :active="request()->routeIs('profile*')" icon="gear" label="Profile" />
            <x-sidebar-item href="{{ route('logout') }}" :active="request()->routeIs('')" icon="right-from-bracket" label="Logout" />
        </div>
    </div>
</div>
