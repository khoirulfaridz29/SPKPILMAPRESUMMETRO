# Task 2: Migration — Add kriteria_id + Create Custom Template Tables

## Files to Create
1. `database/migrations/xxxx_xx_xx_add_kriteria_id_to_rubrik_tables.php`
2. `database/migrations/xxxx_xx_xx_create_rubrik_custom_templates_tables.php`

## Migration 1: add_kriteria_id_to_rubrik_tables

Add nullable `kriteria_id` foreign key to 5 rubrik tables:
- `rubrik_naskah_gk`
- `rubrik_presentasi_gk`
- `rubrik_bahasa_inggris`
- `rubrik_wawancara_cu`
- `rubrik_capaian_unggulan`

Column should go after `jenjang_id`. Use `nullOnDelete()`.

```php
public function up(): void
{
    foreach (['rubrik_naskah_gk','rubrik_presentasi_gk','rubrik_bahasa_inggris','rubrik_wawancara_cu','rubrik_capaian_unggulan'] as $table) {
        Schema::table($table, fn(Blueprint $t) =>
            $t->foreignId('kriteria_id')->nullable()->constrained('kriteria_penilaian')->nullOnDelete()->after('jenjang_id')
        );
    }
}

public function down(): void
{
    foreach (['rubrik_naskah_gk','rubrik_presentasi_gk','rubrik_bahasa_inggris','rubrik_wawancara_cu','rubrik_capaian_unggulan'] as $table) {
        Schema::table($table, fn(Blueprint $t) => {
            $t->dropForeign(['kriteria_id']);
            $t->dropColumn('kriteria_id');
        });
    }
}
```

## Migration 2: create_rubrik_custom_templates_tables

Create 2 tables:

### rubrik_custom_templates
| Column | Type |
|--------|------|
| id | bigint unsigned auto_increment PK |
| nama_template | varchar(255) |
| created_at | timestamp nullable |
| updated_at | timestamp nullable |

### rubrik_custom_template_fields
| Column | Type |
|--------|------|
| id | bigint unsigned auto_increment PK |
| template_id | bigint unsigned FK → rubrik_custom_templates.id ON DELETE CASCADE |
| nama_field | varchar(255) |
| tipe_input | enum('text','number','textarea','score_range') |
| urutan | int default 0 |
| bobot | decimal(5,2) nullable |
| created_at | timestamp nullable |
| updated_at | timestamp nullable |

## Steps
1. Run `php artisan make:migration add_kriteria_id_to_rubrik_tables`
2. Write the migration content
3. Run `php artisan make:migration create_rubrik_custom_templates_tables`
4. Write the migration content
5. Run `php artisan migrate` to verify
