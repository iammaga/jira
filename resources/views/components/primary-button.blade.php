<button {{ $attributes->merge(['type' => 'submit', 'class' => 'py-3 inline-flex items-center justify-center w-full md:w-auto md:py-2 md:px-4 md:text-xs bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
