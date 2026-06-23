# Aturan Pengembangan

## Wajib: Cek di Browser
Sebelum menyelesaikan task, SELALU cek project di browser:
1. Buka `http://127.0.0.1:8000`
2. Login sebagai role terkait (admin/juri/mahasiswa/wr3)
3. Cek apakah halaman muncul tanpa error
4. Cek console browser (F12) untuk JavaScript errors
5. Cek Network tab untuk request gagal (404, 500)
6. Pastikan loading tidak lambat/berat

## Larangan
- Jangan coding buta tanpa verifikasi browser
- Jangan hanya pakai `tinker` atau `curl` sebagai pengganti browser check
- Jangan push/commit sebelum verifikasi browser
