<?php namespace App;

use Illuminate\Support\Facades\DB;
use stdClass;

class BayesAlgorithm {

    private $kuisioner = NULL;
    const OUTPUT_YANG_DIAMBIL = '24';
    const YA = 'Ya';
    const TIDAK = 'Tidak Yakin';

    public function label() {
        return sprintf('p%d', self::OUTPUT_YANG_DIAMBIL);
    }

    public function __construct($kuisioner) {
        $this->kuisioner = $kuisioner;
    }

    public function ambilDataTest() {
        $datatest = $this->kuisioner;
        foreach ($datatest as $index => $test) {
            $datatest[$index]->kuisioner = array_filter($test->kuisioner, function ($pertanyaan){
                return $pertanyaan->id != self::OUTPUT_YANG_DIAMBIL;
            });
        }
        return $datatest;
    }

    public function ambilDataLatih() {
        $path = base_path('dataset.json');
        $file_content = file_get_contents($path);

        $dataset = json_decode($file_content, TRUE);
        return $dataset;
    }

    public function ambilProbabilitasLabel() {
        $datalatih = $this->ambilDataLatih();
        $ya = array_filter($datalatih, function ($item) {
            return strtolower($item[$this->label()]) == strtolower(self::YA);
        });
        $tidak = array_filter($datalatih, function ($item) {
            return strtolower($item[$this->label()]) == strtolower(self::TIDAK);
        });

        return [count($ya), count($tidak)];
    }
    
    public function ambilProbabilitasAttribute($id_pertanyaan, $jawaban) {
        $datalatih = $this->ambilDataLatih();
        $ya = array_filter($datalatih, function ($item) use ($id_pertanyaan, $jawaban) {
            return strtolower($item[$this->label()]) == strtolower(self::YA) && strtolower($item['p'.$id_pertanyaan]) == strtolower($jawaban);
        });

        $tidak = array_filter($datalatih, function ($item) use ($id_pertanyaan, $jawaban) {
            return strtolower($item[$this->label()]) == strtolower(self::TIDAK) && strtolower($item['p'.$id_pertanyaan]) == strtolower($jawaban);
        });

        return [count($ya), count($tidak)];
    }

    public function laplasianCorrection($jenis, $data) {
        list($total_label_ya, $total_label_tidak) = $this->ambilProbabilitasLabel(); 
        foreach ($data->kuisioner as $index => $kuisioner) {
            if ($jenis == 'tidak') {
                $data->kuisioner[$index]->laplasian_tidak = $kuisioner->tidak;
                $total_tidak = $kuisioner->tidak + 1;
                $data->kuisioner[$index]->tidak = $total_tidak;
                $data->kuisioner[$index]->probabilitas_tidak = $total_tidak / ($total_label_tidak + count($data->kuisioner));
            }
            if ($jenis == 'ya') {
                $data->kuisioner[$index]->laplasian_ya = $kuisioner->ya;
                $total_ya = $kuisioner->ya + 1; 
                $data->kuisioner[$index]->ya = $total_ya;
                $data->kuisioner[$index]->probabilitas_ya = $total_ya / ($total_label_ya + count($data->kuisioner));
            }
        }

        $total_probabilitas_ya = $total_label_ya / count($this->ambilDataLatih());
        $total_probabilitas_tidak = $total_label_tidak / count($this->ambilDataLatih());
        foreach ($data->kuisioner as $index => $kuisioner) {
            $total_probabilitas_ya *= $kuisioner->probabilitas_ya;
            $total_probabilitas_tidak *= $kuisioner->probabilitas_tidak;
        }
        
        $data->probabilitas_ya = $total_probabilitas_ya;
        $data->probabilitas_tidak = $total_probabilitas_tidak;

        return $data;
    }

    public function lihatHasilAkhir() {
        $datatest = $this->ambilDataTest();
        list($total_label_ya, $total_label_tidak) = $this->ambilProbabilitasLabel();
        foreach ($datatest as $index => $data) {
            foreach ($data->kuisioner as $idx => $daftar_jawaban) {
                list($ya, $tidak) = $this->ambilProbabilitasAttribute($daftar_jawaban->id, $daftar_jawaban->value);
                $datatest[$index]->kuisioner[$idx]->probabilitas_ya = $ya / $total_label_ya;
                $datatest[$index]->kuisioner[$idx]->probabilitas_tidak = $tidak / $total_label_tidak;
                $datatest[$index]->kuisioner[$idx]->ya = $ya;
                $datatest[$index]->kuisioner[$idx]->tidak = $tidak;
            }
        }

        $datalatih = $this->ambilDataLatih();
        $total_probabilitas_ya = $total_label_ya / count($datalatih);
        $total_probabilitas_tidak = $total_label_tidak / count($datalatih);

        // hitung probabilitas keseluruhan
        foreach ($datatest as $index => $data) {
            $probabilitas_ya = $total_probabilitas_ya;
            $probabilitas_tidak = $total_probabilitas_tidak;
            foreach ($data->kuisioner as $idx => $daftar_jawaban) {
                $probabilitas_ya *= $daftar_jawaban->probabilitas_ya;
                $probabilitas_tidak *= $daftar_jawaban->probabilitas_tidak;
            } 

            $datatest[$index]->probabilitas_ya = $probabilitas_ya;
            $datatest[$index]->probabilitas_tidak = $probabilitas_tidak;
        }

        // normalisasi laplasian correction untuk menghindari nilai 0
        foreach ($datatest as $index => $data) {
            if ($data->probabilitas_ya <= 0) {
                $datatest[$index] = $this->laplasianCorrection('ya', $data);
            }

            if ($data->probabilitas_tidak <= 0) {
                $datatest[$index] = $this->laplasianCorrection('tidak', $data);
            }
        }

        foreach ($datatest as $index => $data) {
            $klasifikasi = self::TIDAK;

            if ($data->probabilitas_ya > $data->probabilitas_tidak) {
                $klasifikasi = self::YA;
            }

            $detail_kuisioner = DB::table('kuisioner')
                ->where('idKuisioner', $data->idKuisioner)
                ->first();

            if ($detail_kuisioner) {
                $nilai_asli = self::YA;
                $kuisioner = Json_decode($detail_kuisioner->kuisioner);
                foreach ($kuisioner as $dt) {
                    if ($dt->id == self::OUTPUT_YANG_DIAMBIL) {
                        $nilai_asli = $dt->value; 
                    }
                }
            }

            if ($klasifikasi == self::YA && $nilai_asli == self::YA) {
                $kategori = 'TP';
            } else if ($klasifikasi == self::YA && $nilai_asli == self::TIDAK) {
                $kategori = 'FP';
            } else if ($klasifikasi == self::TIDAK && $nilai_asli == self::TIDAK) {
                $kategori = 'TN';
            } else if ($klasifikasi == self::TIDAK && $nilai_asli == self::YA) {
                $kategori = 'FN';
            }
            $datatest[$index]->nilai_asli = $nilai_asli;
            $datatest[$index]->klasifikasi = $klasifikasi;
            $datatest[$index]->kategori = $kategori;

        }

        return $datatest;
    }

}