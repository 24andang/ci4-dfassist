<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login, sesuaikan dengan logika autentikasi Anda
        if (!session()->get('inisial')) {
            // Jika belum login, redirect ke halaman login
            return redirect()->to('/', '/hr/rekap/hari_ini', '/karyawan-izin');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu digunakan untuk kasus ini
    }
}
