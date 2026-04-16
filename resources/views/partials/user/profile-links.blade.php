@auth
    @if(!auth()->user()->isAdmin())
        <a href="{{ route('user.profile.edit') }}" class="{{ $desktop ? 'hidden md:inline-flex items-center rounded-2xl border border-pink-200 px-4 py-2 text-sm font-semibold text-pink-600 transition hover:bg-pink-50' : 'block py-2 px-3 rounded-lg transition ' . (request()->routeIs('user.profile.*') ? 'bg-pink-oke-boss text-white font-semibold' : 'text-gray-900 hover:bg-gray-100') }}">
            Profil Saya
        </a>
    @endif
@endauth
