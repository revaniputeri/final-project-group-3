# Schema

Direktori ini berisi berkas-berkas skema untuk database. Ini ditulis dalam
Transact-SQL (T-SQL) dan kompatibel dengan Microsoft SQL Server.

Terdapat 3 berkas dalam direktori ini:
- [schema.sql](./create.sql): File ini berisi create statement untuk database.
- [seed.sql](./seed.sql): File ini berisi data dummy untuk database.
- [drop.sql](./drop.sql): File ini berisi drop statement untuk database.

Sebelum menjalankan aplikasi, Anda harus membuat database dan menyetel data
dummy. Cukup jalankan `schema.sql` dan `seed.sql` secara berurutan untuk membuat
database dan menyetel data dummy.