<?php

namespace App\Models\HR;

use CodeIgniter\Model;
use App\Controllers;

class IzinModel extends Model
{
    protected $DBGroup = 'ci4hr';
    protected $table      = 'surat_izin';
    protected $primaryKey = 'id_izin';

    protected $allowedFields = ['nik', 'inisial', 'nama', 'tanggal_dibuat', 'departemen', 'sisa_cuti', 'periode_cuti', 'total_cuti', 'level', 'alasan_izin', 'sub_alasan', 'izin_awal', 'izin_akhir', 'izin_awal2', 'izin_akhir2', 'tgl_masuk_kerja', 'keterangan', 'kendaraan', 'pengemudi', 'approval1', 'approval2', 'atasan', 'telp', 'alamat'];

    public function filterApproval()
    {
        // Menyaring baris dimana kedua kolom approval1 dan approval2 bernilai 1
        if ('approval1' !== 1 && 'approval2' !== 1) {
            return $this->findAll();
        }
    }

    public function getRekapKehadiran($departemen = null, $startDate = null, $endDate = null)
    {
        $sql = "
        SELECT nik, nama,

        -- alasan_izin = sakit(menghitung sabtu dan minggu), cuti spesial(tidak menghitung sabtu dan minggu)
        SUM(
            CASE 
                WHEN alasan_izin = 'sakit' THEN
                    CASE 
                        WHEN (izin_awal <= :end_date: AND (izin_akhir >= :start_date: OR izin_akhir IS NULL)) THEN
                            CASE
                                WHEN izin_akhir IS NULL THEN 1
                                ELSE
                                    LEAST(
                                        (DATEDIFF(LEAST(:end_date:, izin_akhir), GREATEST(:start_date:, izin_awal)) + 1) - 
                                        (
                                            FLOOR((DATEDIFF(LEAST(:end_date:, izin_akhir), GREATEST(:start_date:, izin_awal)) + 1) / 7) * 2 + 
                                            (CASE WHEN WEEKDAY(LEAST(:end_date:, izin_akhir)) = 6 THEN 1 ELSE 0 END) + 
                                            (CASE WHEN WEEKDAY(GREATEST(:start_date:, izin_awal)) = 0 THEN 1 ELSE 0 END)
                                        ),
                                        DATEDIFF(:end_date:, GREATEST(:start_date:, izin_awal)) + 1
                                    ) 
                                - IFNULL(
                                    (
                                        SELECT COUNT(*) 
                                        FROM cuti_bersama 
                                        WHERE tanggal BETWEEN GREATEST(:start_date:, izin_awal) AND LEAST(:end_date:, izin_akhir)
                                    ), 0
                                )
                            END
                        ELSE 0
                    END
                ELSE 0
            END
        ) AS S,

        -- alasan_izin = cuti(menghitung sabtu dan minggu), cuti spesial(tidak menghitung sabtu dan minggu)
        SUM(
            CASE 
                WHEN alasan_izin = 'cuti' THEN
                    CASE 
                        WHEN (izin_awal <= :end_date: AND (izin_akhir >= :start_date: OR izin_akhir IS NULL)) THEN
                            CASE
                                WHEN izin_akhir IS NULL THEN 1
                                ELSE
                                    LEAST(
                                        (DATEDIFF(LEAST(:end_date:, izin_akhir), GREATEST(:start_date:, izin_awal)) + 1) - 
                                        (
                                            FLOOR((DATEDIFF(LEAST(:end_date:, izin_akhir), GREATEST(:start_date:, izin_awal)) + 1) / 7) * 2 + 
                                            (CASE WHEN WEEKDAY(LEAST(:end_date:, izin_akhir)) = 6 THEN 1 ELSE 0 END) + 
                                            (CASE WHEN WEEKDAY(GREATEST(:start_date:, izin_awal)) = 0 THEN 1 ELSE 0 END)
                                        ),
                                        DATEDIFF(:end_date:, GREATEST(:start_date:, izin_awal)) + 1
                                    ) 
                                - IFNULL(
                                    (
                                        SELECT COUNT(*) 
                                        FROM cuti_bersama 
                                        WHERE tanggal BETWEEN GREATEST(:start_date:, izin_awal) AND LEAST(:end_date:, izin_akhir)
                                    ), 0
                                )
                            END
                        ELSE 0
                    END
                ELSE 0
            END
        ) AS C,

        -- alasan_izin = izin lain-lain(menghitung sabtu dan minggu), cuti spesial(tidak menghitung sabtu dan minggu)
        SUM(
            CASE 
                WHEN alasan_izin = 'izin lain-lain' THEN
                    CASE 
                        WHEN (izin_awal <= :end_date: AND (izin_akhir >= :start_date: OR izin_akhir IS NULL)) THEN
                            CASE
                                WHEN izin_akhir IS NULL THEN 1
                                ELSE
                                    LEAST(
                                        (DATEDIFF(LEAST(:end_date:, izin_akhir), GREATEST(:start_date:, izin_awal)) + 1) - 
                                        (
                                            FLOOR((DATEDIFF(LEAST(:end_date:, izin_akhir), GREATEST(:start_date:, izin_awal)) + 1) / 7) * 2 + 
                                            (CASE WHEN WEEKDAY(LEAST(:end_date:, izin_akhir)) = 6 THEN 1 ELSE 0 END) + 
                                            (CASE WHEN WEEKDAY(GREATEST(:start_date:, izin_awal)) = 0 THEN 1 ELSE 0 END)
                                        ),
                                        DATEDIFF(:end_date:, GREATEST(:start_date:, izin_awal)) + 1
                                    ) 
                                - IFNULL(
                                    (
                                        SELECT COUNT(*) 
                                        FROM cuti_bersama 
                                        WHERE tanggal BETWEEN GREATEST(:start_date:, izin_awal) AND LEAST(:end_date:, izin_akhir)
                                    ), 0
                                )
                            END
                        ELSE 0
                    END
                ELSE 0
            END
        ) AS I,

        -- alasan_izin = pulang lebih awal
        SUM(CASE WHEN alasan_izin = 'pulang lebih awal' THEN 1 ELSE 0 END) AS PA,

        -- alasan_izin =  datang terlambat
        SUM(CASE WHEN alasan_izin = 'datang terlambat' THEN 1 ELSE 0 END) AS Late,

        -- alasan_izin = tidak hadir(menghitung sabtu dan minggu), cuti spesial(tidak menghitung sabtu dan minggu)
        SUM(
            CASE 
                WHEN alasan_izin = 'tidak hadir' THEN
                    CASE 
                        WHEN (izin_awal <= :end_date: AND (izin_akhir >= :start_date: OR izin_akhir IS NULL)) THEN
                            CASE
                                WHEN izin_akhir IS NULL THEN 
                                    (DATEDIFF(:end_date:, :start_date:) + 1) - 
                                    (
                                        FLOOR((DATEDIFF(:end_date:, :start_date:) + 1) / 7) * 2 + 
                                        (CASE WHEN WEEKDAY(:end_date:) = 6 THEN 1 ELSE 0 END) + 
                                        (CASE WHEN WEEKDAY(:start_date:) = 0 THEN 1 ELSE 0 END)
                                    ) 
                                ELSE
                                    LEAST(
                                        (DATEDIFF(LEAST(:end_date:, izin_akhir), GREATEST(:start_date:, izin_awal)) + 1) - 
                                        (
                                            FLOOR((DATEDIFF(LEAST(:end_date:, izin_akhir), GREATEST(:start_date:, izin_awal)) + 1) / 7) * 2 + 
                                            (CASE WHEN WEEKDAY(LEAST(:end_date:, izin_akhir)) = 6 THEN 1 ELSE 0 END) + 
                                            (CASE WHEN WEEKDAY(GREATEST(:start_date:, izin_awal)) = 0 THEN 1 ELSE 0 END)
                                        ),
                                        DATEDIFF(:end_date:, GREATEST(:start_date:, izin_awal)) + 1
                                    ) 
                                - IFNULL(
                                    (
                                        SELECT COUNT(*) 
                                        FROM cuti_bersama 
                                        WHERE tanggal BETWEEN GREATEST(:start_date:, izin_awal) AND LEAST(:end_date:, izin_akhir)
                                    ), 0
                                )
                            END
                        ELSE 0
                    END
                WHEN alasan_izin = 'cuti spesial' THEN
                    CASE 
                        WHEN (izin_awal <= :end_date: AND (izin_akhir >= :start_date: OR izin_akhir IS NULL)) THEN
                            CASE
                                WHEN izin_akhir IS NULL THEN 
                                    (DATEDIFF(:end_date:, :start_date:) + 1) 
                                ELSE
                                    (DATEDIFF(LEAST(:end_date:, izin_akhir), GREATEST(:start_date:, izin_awal)) + 1)
                                - IFNULL(
                                        (
                                        SELECT COUNT(*) 
                                        FROM cuti_bersama 
                                        WHERE tanggal BETWEEN GREATEST(:start_date:, izin_awal) 
                                            AND LEAST(:end_date:, izin_akhir)
                                            AND keterangan = 'weekend'
                                    ), 0
                                )
                            END
                        ELSE 0
                    END
                ELSE 0
            END
        ) AS CL,

        -- alasan_izin = luar kota(menghitung sabtu dan minggu), cuti spesial(tidak menghitung sabtu dan minggu)
        SUM(
            CASE 
                WHEN alasan_izin = 'luar kota' THEN
                    CASE 
                        WHEN (izin_awal <= :end_date: AND (izin_akhir >= :start_date: OR izin_akhir IS NULL)) THEN
                            CASE
                                WHEN izin_akhir IS NULL THEN 1
                                ELSE
                                    LEAST(
                                        (DATEDIFF(LEAST(:end_date:, izin_akhir), GREATEST(:start_date:, izin_awal)) + 1) - 
                                        (
                                            FLOOR((DATEDIFF(LEAST(:end_date:, izin_akhir), GREATEST(:start_date:, izin_awal)) + 1) / 7) * 2 + 
                                            (CASE WHEN WEEKDAY(LEAST(:end_date:, izin_akhir)) = 6 THEN 1 ELSE 0 END) + 
                                            (CASE WHEN WEEKDAY(GREATEST(:start_date:, izin_awal)) = 0 THEN 1 ELSE 0 END)
                                        ),
                                        DATEDIFF(:end_date:, GREATEST(:start_date:, izin_awal)) + 1
                                    ) 
                                - IFNULL(
                                    (
                                        SELECT COUNT(*) 
                                        FROM cuti_bersama 
                                        WHERE tanggal BETWEEN GREATEST(:start_date:, izin_awal) AND LEAST(:end_date:, izin_akhir)
                                    ), 0
                                )
                            END
                        ELSE 0
                    END
                ELSE 0
            END
        ) AS LK
        FROM surat_izin
    ";

        // Filter berdasarkan departemen jika dipilih
        if ($departemen || ($startDate && $endDate)) {
            $sql .= " WHERE 1=1 ";

            // Hanya Approval1 & Approval2 = 1 yang terfilter pada rekap kehadiran ====
            $sql .= " AND approval1=1 AND approval2=1 ";
            // ===========

            if ($departemen) {
                $sql .= " AND departemen = :departemen:";
            }

            if ($startDate && $endDate) {
                $sql .= " AND ((izin_awal >= :start_date: AND izin_awal <= :end_date:) 
                          OR (izin_akhir >= :start_date: AND izin_akhir <= :end_date:) 
                          OR (izin_awal2 >= :start_date: AND izin_awal2 <= :end_date:) 
                          OR (izin_akhir2 >= :start_date: AND izin_akhir2 <= :end_date:))";
            }
        } else {
            // Jika tidak ada filter, tidak mengembalikan data
            return [];
        }

        $sql .= " GROUP BY nik, nama";
        $sql .= " ORDER BY nik ASC";

        // Menjalankan query dengan binding parameter
        $query = $this->db->query($sql, [
            'departemen' => $departemen,
            'start_date' => $startDate,
            'end_date'   => $endDate
        ]);

        return $query->getResultArray();
    }
}
