Prompt Engineering Log - Tugas 3 IAE

Nama: Widia Mesra Nainggolan mahulae
NIM: 102022430029
Layanan: Data Pasien Service
Tanggal: 11 Juni 2026

---

1. Identifikasi Bug pada Kode
Tolong analisis kode patient-service saya dan identifikasi bug yang menyebabkan error di endpoint /api/v1/patients. Fokus pada SSOService.php, SoapAuditService.php, dan PatientController.php.

2. Implementasi PatientController dengan SOAP & AMQP
PatientController@store saya belum memanggil SoapAuditService dan AMQPPublisherService. Tolong bantu tambahkan integrasi keduanya dengan alur yang benar.

3. Troubleshooting Docker & Database Migration
Saat menjalankan php artisan migrate muncul error: Base table or view already exists: 1050 Table 'sso_users' already exists. Bagaimana cara mengatasinya tanpa menghapus tabel yang sudah ada?

4. Troubleshooting M2M Login Key
loginM2M() return null karena access_token tidak ada. Sudah dicek SSO_M2M_KEY=KEY-MHS-88 tapi tetap gagal. ini kenapa?

5. Verifikasi Hasil Testing
Setelah semua perubahan, hasil POST /api/v1/patients mengembalikan 201 dengan audit_receipt: "IAE-LOG-2026-04FD1DC6" dan amqp_published: true. udh bener blm ini?





