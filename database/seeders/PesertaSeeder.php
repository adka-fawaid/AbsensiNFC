<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if pesertas already exist
        $existingCount = \App\Models\Peserta::count();
        
        if ($existingCount > 0) {
            echo "Pesertas already exist ({$existingCount} records). Skipping seeder.\n";
            return;
        }

        $pesertas = [
            ['uid' => '2920189655', 'nama' => 'Moh Adzka Fawaid', 'nim' => 'A11.2022.14656', 'fakultas' => 'Teknik Informatika/Fakultas Ilmu Komputer', 'jabatan' => 'Menteri'],
            ['uid' => '2917117223', 'nama' => 'Ady Chandra', 'nim' => 'A11.2024.16070', 'fakultas' => 'Teknik Informatika/Fakultas Ilmu Komputer', 'jabatan' => 'Staff Ahli'],
            ['uid' => '2919882231', 'nama' => 'Syella Novita Amelia', 'nim' => 'A11.2024.16043', 'fakultas' => 'Teknik Informatika / Fakultas Ilmu Komputer', 'jabatan' => 'Staff Ahli'],
            ['uid' => '2919681607', 'nama' => 'Rafly Ramadhani', 'nim' => 'A11.2024.16066', 'fakultas' => 'Teknik Informatika/Fakultas Ilmu Komputer', 'jabatan' => 'Staff Ahli'],
            ['uid' => '2921053927', 'nama' => 'Wahyu Nur Setyono', 'nim' => 'A11.2022.14633', 'fakultas' => 'Teknik Informatika / Fakultas Ilmu Komputer', 'jabatan' => 'Staff Ahli'],
            ['uid' => '2917306087', 'nama' => 'Akbar Putra Jalu Lastino', 'nim' => 'A11.2024.16044', 'fakultas' => 'Teknik Informatika / Fakultas Ilmu Komputer', 'jabatan' => 'Eksekutif Muda'],
            ['uid' => '2918167815', 'nama' => 'Fuad Anwar Ibrahim Shidiq', 'nim' => 'A11.2024.16047', 'fakultas' => 'Teknik Informatika / Fakultas Ilmu Komputer', 'jabatan' => 'Staff Ahli'],
            ['uid' => '2918322007', 'nama' => 'Najwa Handaria Suparna', 'nim' => 'A11.2024.16039', 'fakultas' => 'Teknik Informatika / Fakultas Ilmu Komputer', 'jabatan' => 'Eksekutif Muda'],
            ['uid' => '2917563063', 'nama' => 'Firdaus Hakiki', 'nim' => 'C11.2022.02536', 'fakultas' => 'Bahasa Inggris / Fakultas Ilmu Budaya', 'jabatan' => 'Menteri'],
            ['uid' => '2918877223', 'nama' => 'Auliya Tegar Panji Budiyono', 'nim' => 'E11.2022.01145', 'fakultas' => 'Teknik Elektro / Fakultas Teknik', 'jabatan' => 'Staff Ahli'],
            ['uid' => '2919570423', 'nama' => 'Parani Wildhiyanaufaldi', 'nim' => 'A11.2023.15370', 'fakultas' => 'Teknik Informatika/ Fakultas Ilmu Komputer', 'jabatan' => 'Staff Ahli'],
            ['uid' => '2919720151', 'nama' => 'Langit Maajid Asy-Syahiidu', 'nim' => 'C12.2022.01099', 'fakultas' => 'Sastra Jepang/Fakultas Ilmu Budaya', 'jabatan' => 'Staff Ahli'],
            ['uid' => '2917588503', 'nama' => 'Dimas Maulana Majid', 'nim' => 'E11.2024.01269', 'fakultas' => 'Teknik Elektro / Fakultas Teknik', 'jabatan' => 'Staff Ahli'],
            ['uid' => '2918744519', 'nama' => 'Chela Jesica', 'nim' => 'D22.2024.03790', 'fakultas' => 'Rekam Medis/Fakultas Kesehatan', 'jabatan' => 'Staff Ahli Kementerian Sosial Politik'],
            ['uid' => '2919062711', 'nama' => 'Kesia Aphrodite Gabriella Ardianie', 'nim' => 'A15.2025.03329', 'fakultas' => 'Ilmu Komunikasi / Fakultas Ilmu Komputer', 'jabatan' => 'Eksekutif Muda Kementerian Sosial Masyarakat'],
            ['uid' => '2919004535', 'nama' => 'Muhammad Rasha Mahdavikia', 'nim' => 'E11.2023.01202', 'fakultas' => 'Teknik Elektro / Fakultas Teknik', 'jabatan' => 'Menteri Kementerian Kesenian, Pendidikan dan Olahraga'],
            ['uid' => '2919322727', 'nama' => 'Danish Ara Zafir Ayesha', 'nim' => 'D22.2024.03792', 'fakultas' => 'Rekam Medis & Informasi Kesehatan/Fakultas Kesehatan', 'jabatan' => 'Staff Ahli Kementerian Kesenian, Pendidikan dan Olahraga'],
            ['uid' => '2918551607', 'nama' => 'Kennard Owen Umbu Riada', 'nim' => 'A11. 2024.16054', 'fakultas' => 'Teknik Informatika/Fakultas Ilmu Komputer', 'jabatan' => 'Eksekutif Muda Kementerian Kesenian, Pendidikan dan Olahraga'],
            ['uid' => '2917776231', 'nama' => 'Ardra Khansa Danendra Daffa Akhmad', 'nim' => 'A11.2024.15927', 'fakultas' => 'Teknik Informatika/Fakultas Ilmu Komputer', 'jabatan' => 'Eksekutif Muda Kementerian Kesenian, Pendidikan dan Olahraga'],
            ['uid' => '2919632983', 'nama' => 'Muhamad Amirul Hassan Waluyo', 'nim' => 'E12.2022.01629', 'fakultas' => 'Teknik Industri / Fakultas Teknik', 'jabatan' => 'Staff Ahli Kementerian Kesenian, Pendidikan dan Olahraga'],
            ['uid' => '2917285831', 'nama' => 'Isa Mahardika Sadino', 'nim' => 'A11.2024.16061', 'fakultas' => 'Teknik Informatika/Fakultas Ilmu Komputer', 'jabatan' => 'Staff Ahli Kementerian Kesenian, Pendidikan dan Olahraga'],
            ['uid' => '2919633047', 'nama' => 'Najwa Alya Putri Rahmadhani', 'nim' => 'A15.2024.03087', 'fakultas' => 'Ilmu Komunikasi/Fakultas Ilmu Komputer', 'jabatan' => 'Staff Ahli Kementerian Kesenian, Pendidikan dan Olahraga'],
            ['uid' => '2919581591', 'nama' => 'Reynavi Ahmadinejad Sulistyo', 'nim' => 'E12. 2025. 02202', 'fakultas' => 'Teknik Industri/Fakuktas Teknik', 'jabatan' => 'Eksekutif Muda Kementerian Kesenian, Pendidikan dan Olahraga'],
            ['uid' => '2919200311', 'nama' => 'Luklu\'un Aula', 'nim' => 'B11.2022.07879', 'fakultas' => 'Manajemen/Fakultas Ekonomi dan Bisnis', 'jabatan' => 'Presiden Mahasiswa'],
            ['uid' => '2919595015', 'nama' => 'Callista Widyaranti', 'nim' => 'B11.2022.07907', 'fakultas' => 'Manajemen/Fakultas Ekonomi dan Bisnis', 'jabatan' => 'Wakil Presiden Mahasiswa'],
            ['uid' => '2921056871', 'nama' => 'Nofa Setianto', 'nim' => 'A15.2022.02334', 'fakultas' => 'Ilmu Komunikasi / Fakultas Ilmu Komputer', 'jabatan' => 'Sekretaris Jenderal'],
            ['uid' => '2919165607', 'nama' => 'Fahrunnisa Amalia Putri', 'nim' => 'B11.2022.07883', 'fakultas' => 'Manajemen/Fakultas Ekonomi dan Bisnis', 'jabatan' => 'Staf Biro Administrasi'],
            ['uid' => '2921053063', 'nama' => 'Fathya Anindita', 'nim' => 'B11.2022.07873', 'fakultas' => 'Manajemen/Fakultas Ekonomi dan Bisnis', 'jabatan' => 'Kepala Biro Keuangan'],
            ['uid' => '2920635095', 'nama' => 'Pinkan Ayu Wijaya', 'nim' => 'C11.2022.02510', 'fakultas' => 'Bahasa Inggris/Fakultas Ilmu Budaya', 'jabatan' => 'Staf Biro Keuangan'],
            ['uid' => '2917407511', 'nama' => 'Tatagh Herawan Santoso', 'nim' => 'E11.2022.01147', 'fakultas' => 'Teknik Elektro / Fakultas Teknik', 'jabatan' => 'Menteri Koordinator Pergerakan'],
            ['uid' => '2919858999', 'nama' => 'Meydika Angga Adi Nugraha', 'nim' => 'E12.2022.01688', 'fakultas' => 'Teknik Industri / Fakultas Teknik', 'jabatan' => 'Menteri Koordinator Penaungan dan Kesejahteraan'],
            ['uid' => '2919569383', 'nama' => 'Alya Rahmadina', 'nim' => 'K11.2023.00011', 'fakultas' => 'Kedokteran / Fakultas Kedokteran', 'jabatan' => 'Menteri Koordinator Relasi dan Inovasi'],
            ['uid' => '2917557223', 'nama' => 'Yasmin Layyinatul Izza', 'nim' => 'E12.2024.01908', 'fakultas' => 'Teknik Industri/Fakultas Teknik', 'jabatan' => 'Menteri Advokasi dan Kesejahteraan Mahasiswa'],
            ['uid' => '2920845735', 'nama' => 'Renaldi alta pramudia', 'nim' => 'B11.2025.09478', 'fakultas' => 'Manajemen/Fakultas Ekonomi dan Bisnis', 'jabatan' => 'Eksekutif Muda Kementerian Advokasi dan Kesejahteraan Mahasiswa'],
            ['uid' => '2920193575', 'nama' => 'Nabeel Raza Destama', 'nim' => 'D11.2025.04315', 'fakultas' => 'Kesehatan Masyarakat/Fakultas Kesehatan', 'jabatan' => 'Eksekutif Muda Kementerian Advokasi dan Kesejahteraan Mahasiswa'],
            ['uid' => '2918296983', 'nama' => 'Ulya Noviana', 'nim' => 'D11.2024.04101', 'fakultas' => 'Kesehatan Masyarakat/Fakultas Kesehatan', 'jabatan' => 'Staf Ahli Kementerian Advokasi dan Kesejahteraan Mahasiswa'],
            ['uid' => '2919334087', 'nama' => 'Vika Aulia Rahma', 'nim' => 'K11.2023.00007', 'fakultas' => 'Kedokteran/Fakultas Kedokteran', 'jabatan' => 'Menteri Kementerian Pengembangan Perempuan dan Inklusifitas'],
            ['uid' => '2920950183', 'nama' => 'Rizka Amalia Dewi', 'nim' => 'D11.2024.04038', 'fakultas' => 'Kesehatan Masyarakat/Fakultas Kesehatan', 'jabatan' => 'Eksekutif Muda Kementerian Pengembangan Perempuan dan Inklusifitas'],
            ['uid' => '2918247127', 'nama' => 'Melani', 'nim' => 'D11.2023.03732', 'fakultas' => 'Kesehatan Masyarakat/Fakultas Kesehatan', 'jabatan' => 'Staff Ahli Kementerian Pengembangan Perempuan dan Inklusifitas'],
            ['uid' => '2920668775', 'nama' => 'Rikha Maharani', 'nim' => 'B12.2024.05010', 'fakultas' => 'Teknik Industri/Fakultas Teknik', 'jabatan' => 'Staff Ahli Kementerian Pengembangan Perempuan dan Inklusifitas'],
            ['uid' => '2918277463', 'nama' => 'Aqilla Yumna Imtiyas', 'nim' => 'K11.2023.00004', 'fakultas' => 'Kedokteran/Fakultas Kedokteran', 'jabatan' => 'Staff Ahli Kementerian Pengembangan Perempuan dan Inklusifitas'],
            ['uid' => '2917962391', 'nama' => 'Ramadhani Artidinata Abiansah', 'nim' => 'A11.2023.15236', 'fakultas' => 'Teknik Informatika/Fakultas Ilmu Komputer', 'jabatan' => 'Menteri Kementerian Luar Negeri'],
            ['uid' => '2918409239', 'nama' => 'Ardhi Azizzul Hakiem', 'nim' => 'A12.2025.07426', 'fakultas' => 'Sistem Informasi / Fakultas Ilmu Komputer', 'jabatan' => 'Eksekutif Muda Kementerian Luar Negeri'],
            ['uid' => '2920790023', 'nama' => 'Tika Nur Firdausiana', 'nim' => 'A12.2023.07080', 'fakultas' => 'Sistem Informasi / Fakultas Ilmu Komputer', 'jabatan' => 'Staff Ahli Kementerian Luar Negeri'],
            ['uid' => '2917874023', 'nama' => 'Marssa Lu\'luil Khusna', 'nim' => 'E12.2025.02196', 'fakultas' => 'Sistem Informasi / Fakultas Ilmu Komputer', 'jabatan' => 'Eksekutif Muda Kementerian Luar Negeri'],
            ['uid' => '2921296375', 'nama' => 'Faqih Rizqian Mahardika', 'nim' => 'E13.2022.00203', 'fakultas' => 'Teknik Biomedis / Fakultas Teknik', 'jabatan' => 'Staff Ahli Kementerian Luar Negeri'],
            ['uid' => '2919111495', 'nama' => 'Ayu Wijaya Mukti Kusumaningrum', 'nim' => 'B11.2023.08610', 'fakultas' => 'Manajemen/Fakultas Ekonomi dan Bisnis', 'jabatan' => 'Eksekutif Muda Kementerian Luar Negeri'],
            ['uid' => '2919288567', 'nama' => 'Theresia Angelina Hungan', 'nim' => 'A15.2025.03155', 'fakultas' => 'Ilmu Komunikasi/Fakultas Ilmu Komputer', 'jabatan' => 'Eksekutif Muda Kementerian Luar Negeri'],
            ['uid' => '2920632359', 'nama' => 'Ichlasul Hadi', 'nim' => 'E12.2022.01655', 'fakultas' => 'Teknik Industri/Fakultas Teknik', 'jabatan' => 'Staf Ahli Kementerian Badan Usaha Milik Keluarga Mahasiswa'],
            ['uid' => '2919567351', 'nama' => 'Muhammad Riko Ivan Habibi', 'nim' => 'E12.2023.01803', 'fakultas' => 'Teknik Industri/Fakultas Teknik', 'jabatan' => 'Menteri Kementerian Badan Usaha Milik Keluarga Mahasiswa'],
            ['uid' => '2918602759', 'nama' => 'Nabilla Luthfia Khairunnisa', 'nim' => 'A15.2024.02885', 'fakultas' => 'Ilmu Komunikasi/Fakultas Ilmu Komputer', 'jabatan' => 'Eksekutif Muda Kementerian Badan Usaha Milik Keluarga Mahasiswa'],
            ['uid' => '2917308231', 'nama' => 'Nabila wahyuningsih', 'nim' => 'E12.2023.01817', 'fakultas' => 'Teknik Industri/Fakultas Teknik', 'jabatan' => 'Eksekutif Muda Kementerian Badan Usaha Milik Keluarga Mahasiswa'],
            ['uid' => '2917608455', 'nama' => 'Agung Aprilyanto', 'nim' => 'E12.2024.02025', 'fakultas' => 'Teknik Industri/Fakultas Teknik', 'jabatan' => 'Eksekutif Muda Kementerian Badan Usaha Milik Keluarga Mahasiswa'],
            ['uid' => '2918132455', 'nama' => 'Rafi Eka Pratama', 'nim' => 'E12.2022.01671', 'fakultas' => 'Teknik Industri/Fakultas Teknik', 'jabatan' => 'Kepala Biro Pengembangan Sumber Daya Mahasiswa'],
            ['uid' => '2918327431', 'nama' => 'Dahlan Agestya Zarkasi', 'nim' => 'E12.2022.01683', 'fakultas' => 'Teknik Industri / Fakultas Teknik', 'jabatan' => 'Staf Biro Pengembangan Sumber Daya Mahasiswa'],
            ['uid' => '2917271319', 'nama' => 'Trisha Putri Priyandari', 'nim' => 'A15.2024.02875', 'fakultas' => 'Ilmu Komunikasi / Fakultas Ilmu Komputer', 'jabatan' => 'Eksekutif Muda Biro Pengembangan Sumber Daya Mahasiswa'],
            ['uid' => '2920014007', 'nama' => 'Eagle Robby Irmawan', 'nim' => 'E13.2022.00205', 'fakultas' => 'Teknik Biomedis / Fakultas Teknik', 'jabatan' => 'Staf Biro Pengembangan Sumber Daya Mahasiswa'],
            ['uid' => '2918465127', 'nama' => 'Yola Enova Sabilla', 'nim' => 'A11.2024.16049', 'fakultas' => 'Teknik Informatika/Fakultas Ilmu Komputer', 'jabatan' => 'Eksekutif Muda Biro Pengembangan Sumber Daya Mahasiswa'],
            ['uid' => '2920300055', 'nama' => 'Hilal Sya\'ban Syarif', 'nim' => 'A11.2024.15931', 'fakultas' => 'Teknik Informatika/Fakultas Ilmu Komputer', 'jabatan' => 'Eksekutif Muda Biro Pengembangan Sumber Daya Mahasiswa'],
            ['uid' => '2917439351', 'nama' => 'Dawam Al Firdaus', 'nim' => 'E12.2022.01702', 'fakultas' => 'Teknik Industri / Fakultas Teknik', 'jabatan' => 'Staf Biro Pengembangan Sumber Daya Mahasiswa'],
            ['uid' => '2918597159', 'nama' => 'Tiara Sekar Rahmawati', 'nim' => 'A14.2022.04131', 'fakultas' => 'Desain Komunikasi Visual/Fakultas Ilmu Komputer', 'jabatan' => 'Menteri Biro Media Komunikasi dan Informasi'],
            ['uid' => '2918917815', 'nama' => 'Alexander Bangkit Sugiharto Pranoto', 'nim' => 'A11.2024.16046', 'fakultas' => 'Teknik Informatika / Fakultas Ilmu Komputer', 'jabatan' => 'Staff Ahli Biro Media Komunikasi dan Informasi'],
            ['uid' => '2919835879', 'nama' => 'Pasha Regita', 'nim' => 'A15.2024.02888', 'fakultas' => 'Ilmu Komunikasi / Fakultas Ilmu Komputer', 'jabatan' => 'Kepala Biro Biro Media Komunikasi dan Informasi'],
            ['uid' => '2917786471', 'nama' => 'Rohmatun Nabila', 'nim' => 'A14.2022.04142', 'fakultas' => 'Desain Komunikasi Visual / Fakultas Ilmu Komputer', 'jabatan' => 'Staff Biro Media Komunikasi dan Informasi'],
            ['uid' => '2920504375', 'nama' => 'Sylvana Anggi Putri br Silalahi', 'nim' => 'A14.2022.04126', 'fakultas' => 'Desain Komunikasi Visual /Fakultas Ilmu Komputer', 'jabatan' => 'Staff Biro Media Komunikasi dan Informasi'],
            ['uid' => '2919983351', 'nama' => 'Ayu Kirania Putri', 'nim' => 'D11.2025.04366', 'fakultas' => 'Kesehatan Masyarakat/Fakultas Kesehatan', 'jabatan' => 'Eksekutif Muda Biro Media Komunikasi dan Informasi'],
            ['uid' => '2921300103', 'nama' => 'Surya Putra Adhi Prastya', 'nim' => 'A11.2025.16223', 'fakultas' => 'Teknik Informatika/Fakultas Ilmu Komputer', 'jabatan' => 'Eksekutif Muda Biro Media Komunikasi dan Informasi'],
            ['uid' => '2921428919', 'nama' => 'Aufa Haziq Zahirul Haq', 'nim' => 'E12.2023.01838', 'fakultas' => 'Teknik Industri / Fakultas Teknik', 'jabatan' => 'Menteri Kementerian Dalam Negeri'],
            ['uid' => '2921044679', 'nama' => 'Dwi Rahma Anggreani', 'nim' => 'E12.2024.01995', 'fakultas' => 'Teknik Industri/Fakuktas Teknik', 'jabatan' => 'Staff Ahli Kementerian Dalam Negeri'],
            ['uid' => '2917932935', 'nama' => 'Anninda Arum Bhakti', 'nim' => 'A15.2024.03035', 'fakultas' => 'Ilmu Komunikasi/Fakultas Ilmu Komputer', 'jabatan' => 'Staff Ahli Kementerian Dalam Negeri'],
            ['uid' => '2921480167', 'nama' => 'Vania Angwen Salsabila', 'nim' => 'B11.2025.09234', 'fakultas' => 'Manajemen/Fakultas Ekonomi dan Bisnis', 'jabatan' => 'Eksekutif Muda Kementerian Luar Negeri'],
            ['uid' => '2921023111', 'nama' => 'Prince Ostheo Ednor', 'nim' => 'A15.2024.03094', 'fakultas' => 'Ilmu Komunikasi/Fakultas Ilmu Komputer', 'jabatan' => 'Staff Ahli Kementerian Dalam Negeri'],
            ['uid' => '2921325623', 'nama' => 'Alsya Artha Alghifari', 'nim' => 'E12.2023.01859', 'fakultas' => 'Teknik Industri/Fakultas Teknik', 'jabatan' => 'Staff Ahli Kementerian Dalam Negeri'],
            ['uid' => '2919536167', 'nama' => 'Muhammad Iqbal Tsabit', 'nim' => 'E12.2023.01807', 'fakultas' => 'Teknik Industri/Fakultas Teknik', 'jabatan' => 'Menteri Kementerian Sosial Masyarakat'],
            ['uid' => '2918465591', 'nama' => 'Qonita Rifdah Nur Wanna', 'nim' => 'B12.2023.04806', 'fakultas' => 'Akuntansi/Fakultas Ekonomi dan Bisnis', 'jabatan' => 'Staff Ahli Kementerian Sosial Masyarakat'],
            ['uid' => '2920337399', 'nama' => 'Nabila Amara Safira', 'nim' => 'D11.2024.04062', 'fakultas' => 'Kesehatan Masyarakat/Fakultas Kesehatan', 'jabatan' => 'Staff Ahli Kementerian Sosial Masyarakat'],
            ['uid' => '2919309927', 'nama' => 'Hazma Insaana Najuda', 'nim' => 'E12.2024.02003', 'fakultas' => 'Teknik Industri/Fakultas Teknik', 'jabatan' => 'Staff Ahli Kementerian Sosial Masyarakat'],
            ['uid' => '2917517895', 'nama' => 'Nuripin Subkhan', 'nim' => 'E11.2024.01255', 'fakultas' => 'Teknik Elektro/Fakultas Teknik', 'jabatan' => 'Staff Ahli Kementerian Sosial Masyarakat'],
            ['uid' => '2920854695', 'nama' => 'Navisha Adha Primasari', 'nim' => 'D12.2024.00300', 'fakultas' => 'Kesehatan Lingkungan/Fakultas Kesehatan', 'jabatan' => 'Eksekutif Muda Kementerian Sosial Masyarakat'],
            ['uid' => '2920559303', 'nama' => 'Annisa Amalia Shofa', 'nim' => 'E12.2023.01845', 'fakultas' => 'Teknik Industri/Fakultas Teknik', 'jabatan' => 'Eksekutif Muda Kementerian Sosial Masyarakat'],
            ['uid' => '2919894199', 'nama' => 'Ramadhan Putra Ardiansyah', 'nim' => 'E12.2022.01618', 'fakultas' => 'Teknik Industri/Fakultas Teknik', 'jabatan' => 'Eksekutif Muda Biro Media Komunikasi dan Informasi'],
        ];

        foreach ($pesertas as $peserta) {
            \App\Models\Peserta::create($peserta);
        }
        
        echo "Created " . count($pesertas) . " peserta records.\n";
    }
}
