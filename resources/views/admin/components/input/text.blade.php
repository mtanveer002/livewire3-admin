<input
  {{ $attributes->merge([
    'class' => 'dark:bg-gray-800 dark:text-white form-input block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed',
  ])->class([
    'border-red-400' => !!$error,
  ]) }}
  maxlength="255"
>