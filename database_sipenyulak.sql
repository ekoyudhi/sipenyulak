/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE IF NOT EXISTS `u7234185_sipenyulak` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `u7234185_sipenyulak`;

CREATE TABLE IF NOT EXISTS `data_wp` (
  `npwp` varchar(15) NOT NULL COMMENT 'TRIAL',
  `nik` varchar(16) NOT NULL COMMENT 'TRIAL',
  `nama` varchar(50) NOT NULL COMMENT 'TRIAL',
  `alamat` varchar(255) NOT NULL COMMENT 'TRIAL',
  `kel` varchar(50) NOT NULL COMMENT 'TRIAL',
  `kec` varchar(50) NOT NULL COMMENT 'TRIAL',
  `kota` varchar(50) NOT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`npwp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_feedback` (
  `id_feedback` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `id_peserta` int(11) DEFAULT NULL COMMENT 'TRIAL',
  `id_penyuluhan` int(11) NOT NULL COMMENT 'TRIAL',
  `isi_feedback` varchar(255) DEFAULT NULL COMMENT 'TRIAL',
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'TRIAL',
  PRIMARY KEY (`id_feedback`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_laporan` (
  `id_laporan` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `id_penyuluhan` int(11) NOT NULL COMMENT 'TRIAL',
  `deskripsi_laporan` longtext NOT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id_laporan`),
  UNIQUE KEY `no_dupe` (`id_penyuluhan`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_link_feedback` (
  `id_penyuluhan` int(11) NOT NULL COMMENT 'TRIAL',
  `unik_string` varchar(50) NOT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id_penyuluhan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_materi` (
  `id_materi` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `id_penyuluhan` int(11) NOT NULL COMMENT 'TRIAL',
  `nama_materi` varchar(50) NOT NULL COMMENT 'TRIAL',
  `deskripsi_materi` varchar(255) DEFAULT NULL COMMENT 'TRIAL',
  `file_materi` longblob NOT NULL COMMENT 'TRIAL',
  `upload_by` varchar(16) NOT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id_materi`),
  UNIQUE KEY `no_dupe` (`id_penyuluhan`,`nama_materi`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_pegawai` (
  `nip` varchar(18) NOT NULL COMMENT 'TRIAL',
  `nama` varchar(50) NOT NULL COMMENT 'TRIAL',
  `kode_jabatan` int(11) NOT NULL COMMENT 'TRIAL',
  `kode_golongan` int(11) NOT NULL COMMENT 'TRIAL',
  `kode_unit` int(11) NOT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_penyuluhan` (
  `id_penyuluhan` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `nama_penyuluhan` varchar(255) NOT NULL COMMENT 'TRIAL',
  `waktu_penyuluhan` datetime NOT NULL COMMENT 'TRIAL',
  `lokasi_penyuluhan` varchar(255) NOT NULL COMMENT 'TRIAL',
  `target_penyuluhan` varchar(255) NOT NULL COMMENT 'TRIAL',
  `tema_penyuluhan` varchar(255) NOT NULL COMMENT 'TRIAL',
  `anggaran_penyuluhan` float NOT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id_penyuluhan`),
  UNIQUE KEY `nama_penyuluhan` (`nama_penyuluhan`,`waktu_penyuluhan`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_peserta` (
  `id_peserta` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `id_penyuluhan` int(11) NOT NULL COMMENT 'TRIAL',
  `npwp_peserta` varchar(15) DEFAULT NULL COMMENT 'TRIAL',
  `nik_peserta` varchar(16) DEFAULT NULL COMMENT 'TRIAL',
  `nama_peserta` varchar(50) NOT NULL COMMENT 'TRIAL',
  `alamat_jalan` varchar(50) NOT NULL COMMENT 'TRIAL',
  `alamat_kelurahan` varchar(50) NOT NULL COMMENT 'TRIAL',
  `alamat_kecamatan` varchar(50) NOT NULL COMMENT 'TRIAL',
  `alamat_kota` varchar(50) NOT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id_peserta`),
  UNIQUE KEY `index_4` (`id_penyuluhan`,`npwp_peserta`,`nik_peserta`,`nama_peserta`,`alamat_jalan`,`alamat_kelurahan`,`alamat_kecamatan`,`alamat_kota`),
  UNIQUE KEY `id_penyuluhan_1` (`id_penyuluhan`,`npwp_peserta`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_presensi` (
  `id_presensi` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `id_peserta` int(11) NOT NULL COMMENT 'TRIAL',
  `id_penyuluhan` int(11) NOT NULL COMMENT 'TRIAL',
  `kehadiran` int(11) NOT NULL COMMENT 'TRIAL',
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'TRIAL',
  PRIMARY KEY (`id_presensi`),
  UNIQUE KEY `idx_id_peserta` (`id_peserta`,`id_penyuluhan`,`kehadiran`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_ref_golongan` (
  `kode_golongan` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `nama_pangkat` varchar(50) NOT NULL COMMENT 'TRIAL',
  `nama_golongan` varchar(50) NOT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`kode_golongan`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_ref_jabatan` (
  `kd_jabatan` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `nama_jabatan` varchar(50) NOT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`kd_jabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_ref_jenis_setoran` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `kode_map` varchar(6) NOT NULL COMMENT 'TRIAL',
  `kode_jenis` varchar(3) NOT NULL COMMENT 'TRIAL',
  `nama_setoran` varchar(50) NOT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_kode_map` (`kode_map`,`kode_jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_ref_pajak` (
  `kode_jenis_pajak` int(11) NOT NULL COMMENT 'TRIAL',
  `nama_jenis_pajak` varchar(50) NOT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`kode_jenis_pajak`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_ref_role` (
  `role` int(11) NOT NULL COMMENT 'TRIAL',
  `ket` varchar(50) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_ref_unit` (
  `kode_unit` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `nama_unit_es_4` varchar(255) DEFAULT NULL COMMENT 'TRIAL',
  `nama_unit_es_3` varchar(255) DEFAULT NULL COMMENT 'TRIAL',
  `nama_unit_es_2` varchar(255) DEFAULT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`kode_unit`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_role` (
  `nip` varchar(18) NOT NULL COMMENT 'TRIAL',
  `role` int(11) NOT NULL DEFAULT 0 COMMENT 'TRIAL',
  PRIMARY KEY (`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_setoran` (
  `npwp` varchar(15) NOT NULL COMMENT 'TRIAL',
  `kdmap` varchar(6) NOT NULL COMMENT 'TRIAL',
  `kjs` varchar(3) NOT NULL COMMENT 'TRIAL',
  `ptntp` varchar(20) NOT NULL COMMENT 'TRIAL',
  `ptmspj` varchar(8) NOT NULL COMMENT 'TRIAL',
  `thnbyr` varchar(4) NOT NULL COMMENT 'TRIAL',
  `blnbyr` varchar(2) NOT NULL COMMENT 'TRIAL',
  `tglbyr` varchar(2) NOT NULL COMMENT 'TRIAL',
  `jumlah` float NOT NULL COMMENT 'TRIAL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_spt` (
  `id_spt` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `npwp` varchar(15) NOT NULL COMMENT 'TRIAL',
  `masa_spt` varchar(8) NOT NULL COMMENT 'TRIAL',
  `status_spt` varchar(50) NOT NULL COMMENT 'TRIAL',
  `jenis_spt` varchar(50) NOT NULL COMMENT 'TRIAL',
  `kode_jenis_pajak_spt` varchar(50) NOT NULL DEFAULT '' COMMENT 'TRIAL',
  `nilai_spt` float NOT NULL DEFAULT 0 COMMENT 'TRIAL',
  PRIMARY KEY (`id_spt`)
) ENGINE=InnoDB AUTO_INCREMENT=2033 DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_status_penyuluhan` (
  `id_status_penyuluhan` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `id_penyuluhan` int(11) NOT NULL COMMENT 'TRIAL',
  `flag` int(11) NOT NULL COMMENT 'TRIAL',
  `action_by` varchar(18) NOT NULL COMMENT 'TRIAL',
  `time_stamp` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'TRIAL',
  PRIMARY KEY (`id_status_penyuluhan`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE IF NOT EXISTS `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TRIAL',
  `user` varchar(20) NOT NULL COMMENT 'TRIAL',
  `pass` varchar(50) NOT NULL COMMENT 'TRIAL',
  `nip` varchar(18) NOT NULL COMMENT 'TRIAL',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_user` (`user`),
  UNIQUE KEY `idx_nip` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='TRIAL';

CREATE TABLE `vw_peserta_dash` (
	`id_penyuluhan` INT(11) NOT NULL COMMENT 'TRIAL',
	`wkt` VARCHAR(10) NULL COLLATE 'utf8mb4_general_ci',
	`jml` BIGINT(21) NOT NULL
) ENGINE=MyISAM;

CREATE TABLE `vw_peserta_hadir` (
	`id_peserta` INT(11) NOT NULL COMMENT 'TRIAL',
	`id_penyuluhan` INT(11) NOT NULL COMMENT 'TRIAL',
	`npwp_peserta` VARCHAR(15) NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`nik_peserta` VARCHAR(16) NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`nama_peserta` VARCHAR(50) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`alamat_jalan` VARCHAR(50) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`alamat_kelurahan` VARCHAR(50) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`alamat_kecamatan` VARCHAR(50) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`alamat_kota` VARCHAR(50) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`kehadiran` INT(11) NOT NULL COMMENT 'TRIAL',
	`time_stamp` DATETIME NOT NULL COMMENT 'TRIAL'
) ENGINE=MyISAM;

CREATE TABLE `vw_updated_status_penyuluhan` (
	`id_status_penyuluhan` INT(11) NOT NULL COMMENT 'TRIAL',
	`id_penyuluhan` INT(11) NOT NULL COMMENT 'TRIAL',
	`flag` INT(11) NOT NULL COMMENT 'TRIAL',
	`action_by` VARCHAR(18) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`time_stamp` DATETIME NOT NULL COMMENT 'TRIAL'
) ENGINE=MyISAM;

CREATE TABLE `vw_user_pegawai_role` (
	`nip` VARCHAR(18) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`nama` VARCHAR(50) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`kode_jabatan` INT(11) NOT NULL COMMENT 'TRIAL',
	`kode_golongan` INT(11) NOT NULL COMMENT 'TRIAL',
	`kode_unit` INT(11) NOT NULL COMMENT 'TRIAL',
	`nama_pangkat` VARCHAR(50) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`nama_golongan` VARCHAR(50) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`nama_jabatan` VARCHAR(50) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`nama_unit_es_4` VARCHAR(255) NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`nama_unit_es_3` VARCHAR(255) NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`nama_unit_es_2` VARCHAR(255) NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`user` VARCHAR(20) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`pass` VARCHAR(50) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`role` INT(11) NOT NULL COMMENT 'TRIAL'
) ENGINE=MyISAM;

CREATE TABLE `vw_user_pegawai_role_lengkap` (
	`nip` VARCHAR(18) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`nama` VARCHAR(50) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`kode_jabatan` INT(11) NOT NULL COMMENT 'TRIAL',
	`kode_golongan` INT(11) NOT NULL COMMENT 'TRIAL',
	`kode_unit` INT(11) NOT NULL COMMENT 'TRIAL',
	`nama_pangkat` VARCHAR(50) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`nama_golongan` VARCHAR(50) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`nama_jabatan` VARCHAR(50) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`nama_unit_es_4` VARCHAR(255) NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`nama_unit_es_3` VARCHAR(255) NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`nama_unit_es_2` VARCHAR(255) NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`user` VARCHAR(20) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`pass` VARCHAR(50) NOT NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci',
	`role` INT(11) NOT NULL COMMENT 'TRIAL',
	`ket` VARCHAR(50) NULL COMMENT 'TRIAL' COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `vw_peserta_dash`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_peserta_dash` AS select `a`.`id_penyuluhan` AS `id_penyuluhan`,`a`.`wkt` AS `wkt`,`b`.`jml` AS `jml` from (((select `u7234185_sipenyulak`.`tb_penyuluhan`.`id_penyuluhan` AS `id_penyuluhan`,date_format(`u7234185_sipenyulak`.`tb_penyuluhan`.`waktu_penyuluhan`,'%Y-%m-%d') AS `wkt` from `u7234185_sipenyulak`.`tb_penyuluhan`)) `a` join (select `u7234185_sipenyulak`.`tb_peserta`.`id_penyuluhan` AS `id_penyuluhan`,count(`u7234185_sipenyulak`.`tb_peserta`.`id_peserta`) AS `jml` from `u7234185_sipenyulak`.`tb_peserta` group by `u7234185_sipenyulak`.`tb_peserta`.`id_penyuluhan`) `b` on(`a`.`id_penyuluhan` = `b`.`id_penyuluhan`));

DROP TABLE IF EXISTS `vw_peserta_hadir`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_peserta_hadir` AS select `tb_peserta`.`id_peserta` AS `id_peserta`,`tb_peserta`.`id_penyuluhan` AS `id_penyuluhan`,`tb_peserta`.`npwp_peserta` AS `npwp_peserta`,`tb_peserta`.`nik_peserta` AS `nik_peserta`,`tb_peserta`.`nama_peserta` AS `nama_peserta`,`tb_peserta`.`alamat_jalan` AS `alamat_jalan`,`tb_peserta`.`alamat_kelurahan` AS `alamat_kelurahan`,`tb_peserta`.`alamat_kecamatan` AS `alamat_kecamatan`,`tb_peserta`.`alamat_kota` AS `alamat_kota`,`tb_presensi`.`kehadiran` AS `kehadiran`,`tb_presensi`.`time_stamp` AS `time_stamp` from (`tb_peserta` join `tb_presensi` on(`tb_peserta`.`id_peserta` = `tb_presensi`.`id_peserta`)) where `tb_presensi`.`kehadiran` = 1;

DROP TABLE IF EXISTS `vw_updated_status_penyuluhan`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_updated_status_penyuluhan` AS select `a`.`id_status_penyuluhan` AS `id_status_penyuluhan`,`a`.`id_penyuluhan` AS `id_penyuluhan`,`a`.`flag` AS `flag`,`a`.`action_by` AS `action_by`,`a`.`time_stamp` AS `time_stamp` from (`u7234185_sipenyulak`.`tb_status_penyuluhan` `a` join (select `u7234185_sipenyulak`.`tb_status_penyuluhan`.`id_penyuluhan` AS `id_penyuluhan`,max(`u7234185_sipenyulak`.`tb_status_penyuluhan`.`time_stamp`) AS `ts` from `u7234185_sipenyulak`.`tb_status_penyuluhan` group by `u7234185_sipenyulak`.`tb_status_penyuluhan`.`id_penyuluhan`) `b` on(`a`.`id_penyuluhan` = `b`.`id_penyuluhan` and `a`.`time_stamp` = `b`.`ts`));

DROP TABLE IF EXISTS `vw_user_pegawai_role`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_user_pegawai_role` AS select `tb_pegawai`.`nip` AS `nip`,`tb_pegawai`.`nama` AS `nama`,`tb_pegawai`.`kode_jabatan` AS `kode_jabatan`,`tb_pegawai`.`kode_golongan` AS `kode_golongan`,`tb_pegawai`.`kode_unit` AS `kode_unit`,`tb_ref_golongan`.`nama_pangkat` AS `nama_pangkat`,`tb_ref_golongan`.`nama_golongan` AS `nama_golongan`,`tb_ref_jabatan`.`nama_jabatan` AS `nama_jabatan`,`tb_ref_unit`.`nama_unit_es_4` AS `nama_unit_es_4`,`tb_ref_unit`.`nama_unit_es_3` AS `nama_unit_es_3`,`tb_ref_unit`.`nama_unit_es_2` AS `nama_unit_es_2`,`tb_user`.`user` AS `user`,`tb_user`.`pass` AS `pass`,`tb_role`.`role` AS `role` from (((((`tb_pegawai` join `tb_ref_golongan`) join `tb_ref_jabatan`) join `tb_ref_unit`) join `tb_user`) join `tb_role`) where `tb_pegawai`.`kode_golongan` = `tb_ref_golongan`.`kode_golongan` and `tb_pegawai`.`kode_jabatan` = `tb_ref_jabatan`.`kd_jabatan` and `tb_pegawai`.`kode_unit` = `tb_ref_unit`.`kode_unit` and `tb_pegawai`.`nip` = `tb_user`.`nip` and `tb_pegawai`.`nip` = `tb_role`.`nip`;

DROP TABLE IF EXISTS `vw_user_pegawai_role_lengkap`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_user_pegawai_role_lengkap` AS select `tb_pegawai`.`nip` AS `nip`,`tb_pegawai`.`nama` AS `nama`,`tb_pegawai`.`kode_jabatan` AS `kode_jabatan`,`tb_pegawai`.`kode_golongan` AS `kode_golongan`,`tb_pegawai`.`kode_unit` AS `kode_unit`,`tb_ref_golongan`.`nama_pangkat` AS `nama_pangkat`,`tb_ref_golongan`.`nama_golongan` AS `nama_golongan`,`tb_ref_jabatan`.`nama_jabatan` AS `nama_jabatan`,`tb_ref_unit`.`nama_unit_es_4` AS `nama_unit_es_4`,`tb_ref_unit`.`nama_unit_es_3` AS `nama_unit_es_3`,`tb_ref_unit`.`nama_unit_es_2` AS `nama_unit_es_2`,`tb_user`.`user` AS `user`,`tb_user`.`pass` AS `pass`,`tb_role`.`role` AS `role`,`tb_ref_role`.`ket` AS `ket` from ((((((`tb_pegawai` join `tb_ref_golongan`) join `tb_ref_jabatan`) join `tb_ref_unit`) join `tb_user`) join `tb_role`) join `tb_ref_role`) where `tb_pegawai`.`kode_golongan` = `tb_ref_golongan`.`kode_golongan` and `tb_pegawai`.`kode_jabatan` = `tb_ref_jabatan`.`kd_jabatan` and `tb_pegawai`.`kode_unit` = `tb_ref_unit`.`kode_unit` and `tb_pegawai`.`nip` = `tb_user`.`nip` and `tb_pegawai`.`nip` = `tb_role`.`nip` and `tb_role`.`role` = `tb_ref_role`.`role`;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
