<?php

namespace App\Http\Controllers;

use App\Models\CRM;
use App\Models\Agreement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportsController extends Controller
{
    public function customer(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('reports.customer', compact('now'));
    }

    public function customerTable(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        $customers = $this->customerReportQuery($request)
            ->paginate(20)
            ->withQueryString();

        $exportLabel = session('last_export_label', '—');

        return view('reports.partials.customer_table', compact('customers', 'exportLabel', 'now'));
    }

    public function exportCustomer(Request $request): StreamedResponse
    {
        $export = $request->get('export', 'current');
        $now = Carbon::now('Asia/Dubai');

        $labelMap = [
            'current'      => 'Export: Current View',
            'pkg1'         => 'Export: PKG-1',
            'pkg2'         => 'Export: PKG-2',
            'pkg3'         => 'Export: PKG-3',
            'pkg4'         => 'Export: PKG-4',
            'all_packages' => 'Export: All Packages',
            'no_contract'  => 'Export: No Contract',
        ];

        session(['last_export_label' => ($labelMap[$export] ?? 'Export') . ' • ' . $now->format('d M Y h:i A')]);

        $query = $this->customerReportQuery($request, false);

        $filename = 'customers_' . $export . '_' . $now->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $columns = [
            'CL Number',
            'Created At',
            'Name',
            'Emirates ID',
            'Nationality',
            'Mobile',
            'Passport No',
            'Emirates',
            'Source',
        ];

        $callback = function () use ($query, $columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);

            $query->chunk(200, function ($customers) use ($handle) {
                foreach ($customers as $c) {
                    $createdAt = $c->created_at ? $c->created_at->format('d M Y') : '';
                    $name = trim(($c->first_name ?? '') . ' ' . ($c->last_name ?? ''));

                    fputcsv($handle, [
                        $c->cl,
                        $createdAt,
                        $name,
                        $c->emirates_id,
                        $c->nationality,
                        $c->mobile,
                        $c->passport_number,
                        $c->state,
                        $c->source,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function customerReportQuery(Request $request, bool $includeAgreementMeta = true): Builder
    {
        $export = $request->get('export', 'current');
        $filter = $request->get('filter', 'all');
        $search = $request->get('search');

        $crmTable = (new CRM)->getTable();

        $pkgMap = [
            'pkg1' => 'PKG-1',
            'pkg2' => 'PKG-2',
            'pkg3' => 'PKG-3',
            'pkg4' => 'PKG-4',
        ];

        $query = CRM::query()->orderByDesc('cl');

        if ($includeAgreementMeta) {
            $query->addSelect([
                'agreement_count' => Agreement::query()
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('agreements.client_id', "{$crmTable}.id"),
                'agreement_package' => Agreement::query()
                    ->select('package')
                    ->whereColumn('agreements.client_id', "{$crmTable}.id")
                    ->latest('id')
                    ->limit(1),
            ]);
        }

        $query->when($search, function ($q) use ($search) {
            $s = trim($search);
            $q->where(function ($x) use ($s) {
                $x->where('cl', 'like', "%{$s}%")
                    ->orWhere('first_name', 'like', "%{$s}%")
                    ->orWhere('last_name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%")
                    ->orWhere('mobile', 'like', "%{$s}%")
                    ->orWhere('emirates_id', 'like', "%{$s}%")
                    ->orWhere('passport_number', 'like', "%{$s}%");
            });
        });

        if (isset($pkgMap[$export])) {
            $pkg = $pkgMap[$export];
            $query->whereExists(function ($sub) use ($pkg, $crmTable) {
                $sub->selectRaw(1)
                    ->from('agreements')
                    ->whereColumn('agreements.client_id', "{$crmTable}.id")
                    ->where('agreements.package', $pkg);
            });
            return $query;
        }

        if ($export === 'all_packages') {
            $query->whereExists(function ($sub) use ($crmTable) {
                $sub->selectRaw(1)
                    ->from('agreements')
                    ->whereColumn('agreements.client_id', "{$crmTable}.id")
                    ->whereIn('agreements.package', ['PKG-1', 'PKG-2', 'PKG-3', 'PKG-4']);
            });
            return $query;
        }

        if ($export === 'no_contract') {
            $query->whereNotExists(function ($sub) use ($crmTable) {
                $sub->selectRaw(1)
                    ->from('agreements')
                    ->whereColumn('agreements.client_id', "{$crmTable}.id");
            });
            return $query;
        }

        if ($filter === 'with_contract') {
            $query->whereExists(function ($sub) use ($crmTable) {
                $sub->selectRaw(1)
                    ->from('agreements')
                    ->whereColumn('agreements.client_id', "{$crmTable}.id");
            });
        } elseif ($filter === 'no_contract') {
            $query->whereNotExists(function ($sub) use ($crmTable) {
                $sub->selectRaw(1)
                    ->from('agreements')
                    ->whereColumn('agreements.client_id', "{$crmTable}.id");
            });
        }

        return $query;
    }
}
