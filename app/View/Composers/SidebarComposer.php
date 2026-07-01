<?php

namespace App\View\Composers;

use App\Models\Jenjang;
use App\Models\KriteriaPenilaian;
use App\Models\NotificationApp;
use App\Models\RubrikNaskahGk;
use App\Models\RubrikPresentasiGk;
use App\Models\RubrikBahasaInggris;
use App\Models\RubrikWawancaraCu;
use App\Models\RubrikCustomTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SidebarComposer
{
    private function mapRubrikType(string $namaKriteria): ?string
    {
        $lower = strtolower($namaKriteria);
        if (str_contains($lower, 'wawancara')) return 'wawancara_cu';
        if (str_contains($lower, 'presentasi')) return 'presentasi_gk';
        if (str_contains($lower, 'naskah')) return 'naskah_gk';
        if (str_contains($lower, 'bahasa inggris') || str_contains($lower, 'bi ') || $lower === 'bi') return 'bahasa_inggris';
        if (str_contains($lower, 'capaian unggulan') || $lower === 'cu') return 'cu';
        if (str_contains($lower, 'gagasan kreatif') || str_contains($lower, 'produk inovatif')) return 'naskah_gk';
        return null;
    }

    public function compose(View $view): void
    {
        if (!Auth::check()) return;

        $sidebarJenjangs = Jenjang::orderBy('id')->get();

        $rubrikLabels = [];
        foreach ($sidebarJenjangs as $sj) {
            $kriterias = KriteriaPenilaian::where('jenjang_id', $sj->id)->get();
            $rubrikTypesFromKriteria = $kriterias->pluck('nama_kriteria')
                ->map(fn($n) => $this->mapRubrikType($n))
                ->filter()
                ->unique();

            $naskahLabel = RubrikNaskahGk::where('jenjang_id', $sj->id)->value('label');
            $presentasiLabel = RubrikPresentasiGk::where('jenjang_id', $sj->id)->value('label');

            $rubrikLabels[$sj->id] = [
                'cu' => [
                    'label' => 'Capaian Unggulan',
                    'exists' => $rubrikTypesFromKriteria->contains('cu'),
                ],
                'naskah_gk' => [
                    'label' => $naskahLabel ?? ($sj->kode_jenjang === 'D3' ? 'Produk Inovatif (PI)' : 'Naskah GK'),
                    'exists' => $rubrikTypesFromKriteria->contains('naskah_gk'),
                ],
                'presentasi_gk' => [
                    'label' => $presentasiLabel ?? ($sj->kode_jenjang === 'D3' ? 'Presentasi PI' : 'Presentasi GK'),
                    'exists' => $rubrikTypesFromKriteria->contains('presentasi_gk'),
                ],
                'bi' => [
                    'label' => RubrikBahasaInggris::where('jenjang_id', $sj->id)->value('label') ?? 'Bahasa Inggris',
                    'exists' => $rubrikTypesFromKriteria->contains('bahasa_inggris'),
                ],
                'wawancara' => [
                    'label' => RubrikWawancaraCu::where('jenjang_id', $sj->id)->value('label') ?? 'Wawancara CU',
                    'exists' => $rubrikTypesFromKriteria->contains('wawancara_cu'),
                ],
            ];
        }

        $customTemplates = RubrikCustomTemplate::with('fields')->get();
        foreach ($sidebarJenjangs as $sj) {
            foreach ($customTemplates as $ct) {
                $hasCustom = KriteriaPenilaian::where('jenjang_id', $sj->id)
                    ->where('nama_kriteria', $ct->nama_template)
                    ->exists();
                if ($hasCustom) {
                    $rubrikLabels[$sj->id]['custom_' . $ct->id] = [
                        'label' => $ct->nama_template,
                        'exists' => true,
                    ];
                }
            }
        }

        $unreadNotifs = NotificationApp::where('user_id', Auth::id())
            ->where('is_read', false)->count();
        $notifs = NotificationApp::where('user_id', Auth::id())
            ->latest()->take(5)->get();

        $view->with(compact('sidebarJenjangs', 'unreadNotifs', 'notifs', 'rubrikLabels'));
    }
}
