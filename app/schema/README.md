# Schema

Direktori ini berisi berkas-berkas skema untuk database. Ini ditulis dalam
Transact-SQL (T-SQL) dan kompatibel dengan Microsoft SQL Server.

## Berkas Utama
- [create.sql](./create.sql): File ini berisi create statement untuk database.
- [seed.sql](./seed.sql): File ini berisi data dummy untuk database.
- [drop.sql](./drop.sql): File ini berisi drop statement untuk database.

## Berkas Seed Spesifik
- [seedAdmin.php](./seedAdmin.php): Menyediakan data dummy untuk admin
- [seedLecturer.php](./seedLecturer.php): Menyediakan data dummy untuk dosen
- [seedStudent.php](./seedStudent.php): Menyediakan data dummy untuk mahasiswa
- [seedAchievement.php](./seedAchievement.php): Menyediakan data dummy untuk prestasi

## Berkas Lainnya
- [select.sql](./select.sql): Berisi query dasar untuk melihat data dari semua tabel

## Prosedur Setup
Sebelum menjalankan aplikasi, Anda harus membuat database dan menyetel data
dummy. Urutan eksekusi yang disarankan:
1. Jalankan `create.sql` untuk membuat struktur database
2. Jalankan seed files secara berurutan:
   - `seedAdmin.php`
   - `seedLecturer.php`
   - `seedStudent.php`
   - `seedAchievement.php`
3. (Opsional) Gunakan `select.sql` untuk memverifikasi data
4. (Opsional) Gunakan `drop.sql` untuk menghapus database saat testing