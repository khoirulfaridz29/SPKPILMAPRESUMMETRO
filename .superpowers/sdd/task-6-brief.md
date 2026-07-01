# Task 6: Custom Template Builder (Rubrik Custom CRUD)

## Files

### Create
- `app/Http/Controllers/Admin/RubrikCustomController.php`
- `resources/views/admin/rubrik_custom/index.blade.php`
- `resources/views/admin/rubrik_custom/create.blade.php`
- `resources/views/admin/rubrik_custom/edit.blade.php`

### Modify
- `routes/web.php` — add resource route
- `app/View/Composers/SidebarComposer.php` — handle custom templates

## Step 1: Routes

In `routes/web.php` (in the admin group, near other rubrik routes):
```php
Route::resource('rubrik-custom', RubrikCustomController::class)->names('admin.rubrik-custom');
```

## Step 2: Controller

Create `app/Http/Controllers/Admin/RubrikCustomController.php`:

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RubrikCustomTemplate;
use App\Models\RubrikCustomTemplateField;
use Illuminate\Http\Request;

class RubrikCustomController extends Controller
{
    public function index()
    {
        $templates = RubrikCustomTemplate::with('fields')->orderBy('id')->get();
        return view('admin.rubrik_custom.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.rubrik_custom.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_template' => 'required|string|max:255',
            'fields' => 'required|array|min:1',
            'fields.*.nama_field' => 'required|string|max:255',
            'fields.*.tipe_input' => 'required|in:text,number,textarea,score_range',
            'fields.*.urutan' => 'nullable|integer|min:0',
            'fields.*.bobot' => 'nullable|numeric|min:0|max:100',
        ]);

        $template = RubrikCustomTemplate::create(['nama_template' => $data['nama_template']]);

        foreach ($data['fields'] as $i => $field) {
            $template->fields()->create([
                'nama_field' => $field['nama_field'],
                'tipe_input' => $field['tipe_input'],
                'urutan' => $field['urutan'] ?? $i,
                'bobot' => $field['bobot'] ?? null,
            ]);
        }

        return redirect()->route('admin.rubrik-custom.index')->with('success', 'Template rubrik custom berhasil dibuat.');
    }

    public function edit(RubrikCustomTemplate $rubrik_custom_template)
    {
        $template = $rubrik_custom_template->load('fields');
        return view('admin.rubrik_custom.edit', compact('template'));
    }

    public function update(Request $request, RubrikCustomTemplate $rubrik_custom_template)
    {
        $data = $request->validate([
            'nama_template' => 'required|string|max:255',
            'fields' => 'required|array|min:1',
            'fields.*.nama_field' => 'required|string|max:255',
            'fields.*.tipe_input' => 'required|in:text,number,textarea,score_range',
            'fields.*.urutan' => 'nullable|integer|min:0',
            'fields.*.bobot' => 'nullable|numeric|min:0|max:100',
        ]);

        $rubrik_custom_template->update(['nama_template' => $data['nama_template']]);
        $rubrik_custom_template->fields()->delete();

        foreach ($data['fields'] as $i => $field) {
            $rubrik_custom_template->fields()->create([
                'nama_field' => $field['nama_field'],
                'tipe_input' => $field['tipe_input'],
                'urutan' => $field['urutan'] ?? $i,
                'bobot' => $field['bobot'] ?? null,
            ]);
        }

        return redirect()->route('admin.rubrik-custom.index')->with('success', 'Template rubrik custom berhasil diperbarui.');
    }

    public function destroy(RubrikCustomTemplate $rubrik_custom_template)
    {
        $rubrik_custom_template->delete();
        return redirect()->route('admin.rubrik-custom.index')->with('success', 'Template rubrik custom berhasil dihapus.');
    }
}
```

## Step 3: Index View

`resources/views/admin/rubrik_custom/index.blade.php`:

```blade
@extends('layouts.dashboard')
@section('title', 'Rubrik Custom')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-puzzle-piece me-2"></i> Template Rubrik Custom</h4>
    <a href="{{ route('admin.rubrik-custom.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> Tambah Template</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Template</th>
                    <th>Jumlah Field</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $t->nama_template }}</td>
                    <td>{{ $t->fields->count() }}</td>
                    <td>
                        <a href="{{ route('admin.rubrik-custom.edit', $t) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-edit"></i></a>
                        <form action="{{ route('admin.rubrik-custom.destroy', $t) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus template?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">Belum ada template.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
```

## Step 4: Create View (Dynamic Form Builder)

`resources/views/admin/rubrik_custom/create.blade.php`:

```blade
@extends('layouts.dashboard')
@section('title', 'Tambah Template Rubrik Custom')

@section('content')
<div class="card">
    <div class="card-header"><i class="fa-solid fa-plus me-2"></i> Tambah Template Rubrik Custom</div>
    <div class="card-body">
        <form action="{{ route('admin.rubrik-custom.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Template</label>
                <input type="text" name="nama_template" class="form-control" required placeholder="Cth: Penilaian Kreativitas">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Field Rubrik</label>
                <div id="fields-container">
                    <div class="row g-2 mb-2 field-row">
                        <div class="col-4"><input type="text" name="fields[0][nama_field]" class="form-control" placeholder="Nama field" required></div>
                        <div class="col-3">
                            <select name="fields[0][tipe_input]" class="form-select">
                                <option value="text">Text</option>
                                <option value="number">Number</option>
                                <option value="textarea">Textarea</option>
                                <option value="score_range">Score Range</option>
                            </select>
                        </div>
                        <div class="col-2"><input type="number" name="fields[0][urutan]" class="form-control" placeholder="Urutan" value="0"></div>
                        <div class="col-2"><input type="number" name="fields[0][bobot]" class="form-control" placeholder="Bobot" step="0.01"></div>
                        <div class="col-1"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.field-row').remove()"><i class="fa-solid fa-xmark"></i></button></div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mt-1" onclick="addField()"><i class="fa-solid fa-plus me-1"></i> Tambah Field</button>
            </div>

            <button type="submit" class="btn btn-primary w-100">Simpan Template</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
let fieldIndex = 1;
function addField() {
    const html = `<div class="row g-2 mb-2 field-row">
        <div class="col-4"><input type="text" name="fields[${fieldIndex}][nama_field]" class="form-control" placeholder="Nama field" required></div>
        <div class="col-3">
            <select name="fields[${fieldIndex}][tipe_input]" class="form-select">
                <option value="text">Text</option>
                <option value="number">Number</option>
                <option value="textarea">Textarea</option>
                <option value="score_range">Score Range</option>
            </select>
        </div>
        <div class="col-2"><input type="number" name="fields[${fieldIndex}][urutan]" class="form-control" placeholder="Urutan" value="0"></div>
        <div class="col-2"><input type="number" name="fields[${fieldIndex}][bobot]" class="form-control" placeholder="Bobot" step="0.01"></div>
        <div class="col-1"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.field-row').remove()"><i class="fa-solid fa-xmark"></i></button></div>
    </div>`;
    document.getElementById('fields-container').insertAdjacentHTML('beforeend', html);
    fieldIndex++;
}
</script>
@endpush
@endsection
```

## Step 5: Edit View

Similar to create but with pre-loaded data. Create `resources/views/admin/rubrik_custom/edit.blade.php`.

Extend `layouts.dashboard`. Title: "Edit Template Rubrik Custom". Use `$template` variable.

The form action: `{{ route('admin.rubrik-custom.update', $template) }}` with `@method('PUT')`.

Pre-populate fields from `$template->fields`:
```blade
@foreach($template->fields as $i => $f)
<div class="row g-2 mb-2 field-row">
    <div class="col-4"><input type="text" name="fields[{{ $i }}][nama_field]" class="form-control" value="{{ $f->nama_field }}" required></div>
    <div class="col-3">
        <select name="fields[{{ $i }}][tipe_input]" class="form-select">
            <option value="text" {{ $f->tipe_input == 'text' ? 'selected' : '' }}>Text</option>
            <option value="number" {{ $f->tipe_input == 'number' ? 'selected' : '' }}>Number</option>
            <option value="textarea" {{ $f->tipe_input == 'textarea' ? 'selected' : '' }}>Textarea</option>
            <option value="score_range" {{ $f->tipe_input == 'score_range' ? 'selected' : '' }}>Score Range</option>
        </select>
    </div>
    <div class="col-2"><input type="number" name="fields[{{ $i }}][urutan]" class="form-control" value="{{ $f->urutan }}"></div>
    <div class="col-2"><input type="number" name="fields[{{ $i }}][bobot]" class="form-control" value="{{ $f->bobot }}" step="0.01"></div>
    <div class="col-1"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.field-row').remove()"><i class="fa-solid fa-xmark"></i></button></div>
</div>
@endforeach
```

Include the same `addField()` JS.

## Step 6: Update SidebarComposer

In `app/View/Composers/SidebarComposer.php`, in the `compose` method, after the existing rubrik types loop, add handling for custom types:

```php
// Add custom templates to rubrikLabels
$customTemplates = RubrikCustomTemplate::with('fields')->get();
foreach ($sidebarJenjangs as $sj) {
    foreach ($customTemplates as $ct) {
        // Check if any kriteria uses this template for this jenjang
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
```

Then in the sidebar view (`dashboard.blade.php`), after the existing rubrik links, add custom template links:
```blade
@foreach($rubrikLabels[$sj->id] ?? [] as $key => $rl)
    @if(str_starts_with($key, 'custom_') && ($rl['exists'] ?? false))
    <a href="{{ route('admin.rubrik-custom.index') }}" class="nav-link" style="padding-left:36px;font-size:12px">
        <i class="fa-solid fa-puzzle-piece fa-fw"></i><span class="nav-label"> {{ $rl['label'] }}</span>
    </a>
    @endif
@endforeach
```

## Step 7: Verify

- Run `php artisan route:list` to verify routes
- Run `php artisan view:cache` to check blade syntax
- Commit with message: "feat: custom template builder CRUD"
