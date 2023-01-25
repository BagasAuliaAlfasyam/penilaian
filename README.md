Penjelasan: 

Aplikasi ini adalah aplikasi pengolahan nilai siswa berbasis web yang dibuat menggunakan framework laravel 8. Tujuan dari aplikasi ini adalah agar dapat mengolah data nilai, yang kemudian dapat mencetak nilai akhir yaitu nilai RAPORT. Aplikasi ini memiliki 3 role akses yaitu admin, guru dan wali kelas.





Requirement:

1. php >= 7
2. composer >= 2.3.5





Cara menjalankan:

1. Download aplikasi ini
2. Masuk ke direcroty penyimpanan aplikasi ini
3. Buat database di phpmyadmin
4. Masuk ke file .env pada aplikasi ini, kemudian ganti DB_DATABASE dengan nama database yang telah dibuat di phpmyadmin
5. Jalankan perintah:
   - composer install
   - php artisan migrate
   - php artisan tinker
     - User::create(['name'=>'admin','username'=>'admin','email'=>'admin@gmail.com','role'=>'admin','password'=>bcrypt('password')]);
6. Kemudian login dengan user yang telah didaftarkan
 
