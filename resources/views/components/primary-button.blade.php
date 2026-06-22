<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-2xl border border-transparent bg-gradient-to-r from-indigo-600 to-violet-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-500/20 transition duration-200 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-indigo-500/25 focus:outline-none focus:ring-4 focus:ring-indigo-500/20']) }}>
    {{ $slot }}
</button>
