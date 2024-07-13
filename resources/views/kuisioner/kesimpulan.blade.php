@extends('layouts.main')

@section('main')
<div class="row mg-t-20 flex">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto">
    <div class="normal-table-list" style="margin-bottom: 40px">
        <div class="basic-tb-hd">
            <h2>Kesimpulan Kategori</h2>
        </div>
        <div class="bsc-tbl-st">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>TN</td>
                        <td>{{ $kesimpulan->total_tn }}</td>
                    </tr>
                    <tr>
                        <td>TP</td>
                        <td>{{ $kesimpulan->total_tp }}</td>
                    </tr>
                    <tr>
                        <td>FP</td>
                        <td>{{ $kesimpulan->total_fp }}</td>
                    </tr>
                    <tr>
                        <td>FN</td>
                        <td>{{ $kesimpulan->total_fn }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="normal-table-list" style="margin-bottom: 40px">
        <div class="basic-tb-hd">
            <h2>Kesimpulan Analisis</h2>
        </div>
        <div class="bsc-tbl-st">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Akurasi</td>
                        <td>{{ ($kesimpulan->total_tp + $kesimpulan->total_tn ) / ($kesimpulan->total_tp + $kesimpulan->total_fn + $kesimpulan->total_tn + $kesimpulan->total_fp) * 100 }}</td>
                    </tr>
                    <tr>
                        <td>Presisi</td>
                        @php
                            $presisi = $kesimpulan->total_tp /( $kesimpulan->total_tp + $kesimpulan->total_fp) * 100; 
                        @endphp
                        <td>{{ $presisi }}</td>
                    </tr>
                    <tr>
                        <td>Recall</td>
                        @php 
                            $recall = $kesimpulan->total_tp /( $kesimpulan->total_tp + $kesimpulan->total_fn) * 100;
                        @endphp
                        <td>{{ $recall }}</td>
                    </tr>
                    <tr>
                        <td>F1 Score</td>
                        <td>{{ (2 * $presisi * $recall) / ($presisi + $recall) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection