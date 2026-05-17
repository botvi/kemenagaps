<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PertanyaanUmum;
use App\Models\PaketHaji;
use App\Models\Informasi;
use App\Models\JadwalKeberangkatan;
use App\Models\JadwalManasik;
use App\Models\CalonJemaah;

class ChatBotController extends Controller
{
    public function getFaqs()
    {
        $faqs = PertanyaanUmum::where('published', true)->orderBy('urutan', 'asc')->get();
        return response()->json($faqs);
    }

    public function sendMessage(Request $request)
    {
        $message = strtolower(trim($request->input('message')));
        $words = explode(' ', $message);

        // 1. Cek Exact/Fuzzy Match di FAQ (Pertanyaan Umum)
        $faqs = PertanyaanUmum::where('published', true)->get();
        foreach ($faqs as $faq) {
            $faqQ = strtolower($faq->pertanyaan);
            if (str_contains($faqQ, $message) || str_contains($message, $faqQ)) {
                return response()->json([
                    'reply' => $faq->jawaban,
                    'type' => 'faq'
                ]);
            }
        }

        // 2. Simulasi AI: Deteksi Intent/Maksud Pertanyaan
        $isJadwal = str_contains($message, 'jadwal') || str_contains($message, 'berangkat') || str_contains($message, 'kapan') || str_contains($message, 'tanggal');
        $isManasik = str_contains($message, 'manasik') || str_contains($message, 'latihan') || str_contains($message, 'persiapan');
        $isHarga = str_contains($message, 'harga') || str_contains($message, 'biaya') || str_contains($message, 'bayar') || str_contains($message, 'dp') || str_contains($message, 'berapa');
        $isFasilitas = str_contains($message, 'fasilitas') || str_contains($message, 'dapat apa') || str_contains($message, 'penginapan') || str_contains($message, 'hotel');
        $isPaket = str_contains($message, 'paket') || str_contains($message, 'haji') || str_contains($message, 'umrah') || str_contains($message, 'program') || str_contains($message, 'layanan');
        $isInformasi = str_contains($message, 'informasi') || str_contains($message, 'berita') || str_contains($message, 'terbaru') || str_contains($message, 'artikel') || str_contains($message, 'info');
        $isJemaah = str_contains($message, 'jemaah') || str_contains($message, 'jumlah') || str_contains($message, 'pendaftar') || str_contains($message, 'kuota') || str_contains($message, 'sisa');

        $reply = "";

        // A. JIKA BERTANYA JADWAL MANASIK
        if ($isManasik) {
            $manasiks = JadwalManasik::where('status', '!=', 'Batal')
                ->where('tanggal', '>=', now()->format('Y-m-d'))
                ->orderBy('tanggal', 'asc')
                ->take(3)
                ->get();
            if ($manasiks->count() > 0) {
                $reply .= "Berikut jadwal manasik terdekat:\n";
                foreach ($manasiks as $manasik) {
                    $tanggal = \Carbon\Carbon::parse($manasik->tanggal)->translatedFormat('d F Y');
                    $waktuMulai = \Carbon\Carbon::parse($manasik->waktu_mulai)->format('H:i');
                    $waktuSelesai = \Carbon\Carbon::parse($manasik->waktu_selesai)->format('H:i');
                    $reply .= "🕋 **{$manasik->judul_kegiatan}**\n";
                    $reply .= "   📅 Tanggal: {$tanggal} | ⏰ {$waktuMulai}-{$waktuSelesai} WIB\n";
                    $reply .= "   📍 Lokasi: {$manasik->lokasi} | 👤 Pemateri: {$manasik->pemateri}\n\n";
                }
            } else {
                $reply .= "Maaf, saat ini belum ada jadwal manasik terdekat.\n\n";
            }
        }

        // B. JIKA BERTANYA JUMLAH JEMAAH ATAU KUOTA PER PAKET/JADWAL
        if ($isJemaah) {
            $jadwals = JadwalKeberangkatan::where('is_active', true)
                ->where('tanggal_keberangkatan', '>=', now())
                ->with('paketHaji')
                ->orderBy('tanggal_keberangkatan', 'asc')
                ->get();
            if ($jadwals->count() > 0) {
                $reply .= "Berikut informasi jumlah jemaah dan kuota per jadwal paket:\n";
                foreach ($jadwals as $jadwal) {
                    $namaPaket = $jadwal->paketHaji ? $jadwal->paketHaji->nama_paket : 'Paket Tidak Diketahui';
                    $tanggal = \Carbon\Carbon::parse($jadwal->tanggal_keberangkatan)->translatedFormat('d F Y');
                    
                    // Menghitung spesifik dari model CalonJemaah untuk paket dan jadwal tersebut
                    $jumlahPendaftar = CalonJemaah::where('jadwal_keberangkatan_id', $jadwal->id)->count();
                    $sisaKuota = max(0, $jadwal->kuota - $jumlahPendaftar);
                    
                    $reply .= "👥 **{$namaPaket}** ({$tanggal})\n";
                    $reply .= "   Kapasitas: {$jadwal->kuota} orang | Pendaftar: {$jumlahPendaftar} jemaah | Sisa Kuota: {$sisaKuota} orang\n\n";
                }
            } else {
                $reply .= "Saat ini belum ada informasi keberangkatan dan kuota yang aktif.\n\n";
            }
        }

        // C. JIKA BERTANYA JADWAL / KEBERANGKATAN UMUM
        if ($isJadwal && !$isManasik && !$isJemaah) {
            $jadwals = JadwalKeberangkatan::where('is_active', true)
                ->where('tanggal_keberangkatan', '>=', now())
                ->with('paketHaji')
                ->orderBy('tanggal_keberangkatan', 'asc')
                ->take(4)
                ->get();
            if ($jadwals->count() > 0) {
                $reply .= "Berikut jadwal keberangkatan terdekat yang masih aktif:\n";
                foreach ($jadwals as $jadwal) {
                    $tanggal = \Carbon\Carbon::parse($jadwal->tanggal_keberangkatan)->translatedFormat('d F Y');
                    $jumlahPendaftar = CalonJemaah::where('jadwal_keberangkatan_id', $jadwal->id)->count();
                    $sisaKuota = max(0, $jadwal->kuota - $jumlahPendaftar);
                    $namaPaket = $jadwal->paketHaji ? $jadwal->paketHaji->nama_paket : 'Paket Tidak Diketahui';
                    $reply .= "✈️ **{$namaPaket}** — Berangkat: {$tanggal} (Sisa Kuota: {$sisaKuota} orang)\n";
                }
                $reply .= "\n";
            } else {
                $reply .= "Maaf, saat ini belum ada jadwal keberangkatan terdekat yang aktif.\n\n";
            }
        }

        // D. JIKA BERTANYA HARGA, FASILITAS, ATAU PAKET
        if ($isHarga || $isFasilitas || $isPaket) {
            $query = PaketHaji::where('published', true);
            $hasKeyword = false;
            foreach ($words as $word) {
                if (strlen($word) > 3 && !in_array($word, ['apa', 'aja', 'yang', 'itu', 'berapa', 'harganya', 'fasilitasnya', 'jadwalnya', 'paket'])) {
                    $hasKeyword = true;
                    $query->where(function ($q) use ($word) {
                        $q->orWhere('nama_paket', 'like', "%{$word}%")
                            ->orWhere('kategori', 'like', "%{$word}%");
                    });
                }
            }

            $pakets = $query->take(3)->get();
            if ($pakets->isEmpty()) {
                $pakets = PaketHaji::where('published', true)->take(3)->get();
            }

            if ($pakets->count() > 0) {
                $reply .= "Tentu, ini beberapa paket ibadah yang kami tawarkan:\n";
                foreach ($pakets as $paket) {
                    $harga = number_format($paket->harga, 0, ',', '.');
                    $reply .= "🕋 **{$paket->nama_paket}** ({$paket->kategori})\n";

                    if ($isHarga || $isPaket || (!$isJadwal && !$isFasilitas)) {
                        $reply .= "   💰 Harga: Rp {$harga} | Durasi: {$paket->durasi}\n";
                    }
                    if ($isFasilitas || $isPaket) {
                        $fasilitas = \Illuminate\Support\Str::limit(strip_tags($paket->fasilitas), 90);
                        $reply .= "   ✨ Fasilitas: {$fasilitas}\n";
                    }
                }
                $reply .= "\n";
            }
        }

        // E. JIKA BERTANYA INFORMASI / BERITA TERBARU
        if ($isInformasi && !$isManasik) {
            $informasis = Informasi::where('published', true)->latest()->take(3)->get();
            if ($informasis->count() > 0) {
                $reply .= "Ini informasi & berita terbaru dari kami:\n";
                foreach ($informasis as $info) {
                    $tanggal = \Carbon\Carbon::parse($info->tanggal_terbit)->translatedFormat('d M Y');
                    $reply .= "📰 **{$info->judul}** ({$tanggal})\n";
                }
                $reply .= "Silakan kunjungi halaman 'Informasi' untuk membaca selengkapnya.\n\n";
            }
        }

        // F. FALLBACK JIKA SISTEM TIDAK MENDETEKSI INTENT (SEARCH SEMUA MODEL)
        if (empty(trim($reply))) {
            $queryInfo = Informasi::where('published', true);
            $queryPaket = PaketHaji::where('published', true);
            $queryManasik = JadwalManasik::query();
            
            $hasKeyword = false;

            foreach ($words as $word) {
                if (strlen($word) > 3) {
                    $hasKeyword = true;
                    $queryInfo->orWhere('judul', 'like', "%{$word}%")->orWhere('konten', 'like', "%{$word}%");
                    $queryPaket->orWhere('nama_paket', 'like', "%{$word}%")->orWhere('fasilitas', 'like', "%{$word}%");
                    $queryManasik->orWhere('judul_kegiatan', 'like', "%{$word}%")->orWhere('lokasi', 'like', "%{$word}%")->orWhere('pemateri', 'like', "%{$word}%");
                }
            }

            if ($hasKeyword) {
                $paketMatches = $queryPaket->take(2)->get();
                $infoMatches = $queryInfo->take(2)->get();
                $manasikMatches = $queryManasik->take(2)->get();

                if ($paketMatches->count() > 0) {
                    $reply .= "Pencarian paket terkait:\n";
                    foreach ($paketMatches as $paket) {
                        $reply .= "- **{$paket->nama_paket}** (Rp " . number_format($paket->harga, 0, ',', '.') . ")\n";
                    }
                }
                if ($manasikMatches->count() > 0) {
                    $reply .= "Pencarian jadwal manasik terkait:\n";
                    foreach ($manasikMatches as $manasik) {
                        $tanggal = \Carbon\Carbon::parse($manasik->tanggal)->translatedFormat('d F Y');
                        $reply .= "- **{$manasik->judul_kegiatan}** ({$tanggal} di {$manasik->lokasi})\n";
                    }
                }
                if ($infoMatches->count() > 0) {
                    $reply .= "Pencarian artikel terkait:\n";
                    foreach ($infoMatches as $info) {
                        $reply .= "- *{$info->judul}*\n";
                    }
                }
            }
        }

        // G. JAWABAN DEFAULT JIKA BENAR-BENAR TIDAK ADA KECOCOKAN
        if (empty(trim($reply))) {
            $reply = "Maaf, saya kurang paham maksud Anda. 🤔\n\nCoba ketikkan:\n- 'Paket haji'\n- 'Harga umrah'\n- 'Jadwal keberangkatan'\n- 'Jadwal manasik'\n- 'Jumlah jemaah'\n- 'Informasi terbaru'";
        }

        return response()->json([
            'reply' => nl2br(trim($reply)),
            'type' => 'ai_search'
        ]);
    }
}

