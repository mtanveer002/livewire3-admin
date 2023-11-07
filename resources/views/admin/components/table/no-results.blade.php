<tfoot>
  <tr>
    <td colspan="50" class="flex-col p-12 space-y-4 text-sm text-center bg-white dark:bg-gray-800">
      <div class="text-gray-700 dark:text-gray-400">
        @if($slot->isEmpty())
          <strong>{{ __('notifications.sorry') }}</strong> 
          {{ __('notifications.search-results.none') }}
        @else
          {{ $slot }}
        @endif
      </div>
    </td>
  </tr>
</tfoot>
