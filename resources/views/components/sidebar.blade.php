<div class="bg-white/45 backdrop-blur-xl scrollbar h-full overflow-x-auto rounded-lg shadow-lg p-3">
    <div class="shadow-sm  flex justify-evenly items-center rounded-xl backdrop-blur-2xl p-2">
        <img src="{{ asset('img/logo.png') }}" alt="logo" class="w-10 h-10 " />
        <h1 class="gradient-text font-extrabold">Workshop Event</h1>
    </div>
    <ul class="mt-10 space-y-2 font-semibold">
        <x-sidebar-item href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="home" label="Dashboard" />

        <x-sidebar-item href="{{ route('user.index') }}" :active="request()->routeIs('user*')" icon="user" label="Users" />

        <x-sidebar-item href="{{ route('workshop.index') }}" :active="request()->routeIs('workshop*')" icon="calendar-days" label="Workshop" />

        <x-sidebar-item href="{{ route('dashboard') }}" :active="request()->routeIs('banner*')" icon="images" label="Banners" />

        <x-sidebar-item href="{{ route('feedback.index') }}" :active="request()->routeIs('feedback*')" icon="comments" label="Feedback" />

        <x-sidebar-item href="{{ route('participants.index') }}" :active="request()->routeIs('participants*')" icon="users"
            label="Participants" />
    </ul>

</div>
