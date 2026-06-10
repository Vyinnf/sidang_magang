<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;

trait InteractsWithTableQuery
{
   /**
    * Standarisasi parameter table query agar konsisten lintas halaman index.
    */
   protected function resolveTableQuery(
      Request $request,
      array $allowedSorts,
      string $defaultSort = 'created_at',
      string $defaultDir = 'desc',
      int $defaultPerPage = 10
   ): array {
      $perPageOptions = [10, 25, 50, 100];

      $q = trim((string) $request->query('q', ''));
      $sort = (string) $request->query('sort', $defaultSort);
      $dir = strtolower((string) $request->query('dir', $defaultDir));
      $perPage = (int) $request->query('per_page', $defaultPerPage);
      $from = $request->query('from');
      $to = $request->query('to');

      if (!in_array($sort, $allowedSorts, true)) {
         $sort = $defaultSort;
      }

      if (!in_array($dir, ['asc', 'desc'], true)) {
         $dir = $defaultDir;
      }

      if (!in_array($perPage, $perPageOptions, true)) {
         $perPage = $defaultPerPage;
      }

      return [
         'q' => $q,
         'sort' => $sort,
         'dir' => $dir,
         'per_page' => $perPage,
         'from' => $from,
         'to' => $to,
      ];
   }

   /**
    * Normalisasi nilai filter agar mudah dipakai di view.
    */
   protected function resolveFilter(Request $request, string $key, ?array $allowed = null, $default = null)
   {
      $value = $request->query($key, $default);

      if (is_array($allowed) && !in_array($value, $allowed, true)) {
         return $default;
      }

      return $value;
   }
}
