@extends('layouts.main')

@section('main')
<div class="notika-status-area mg-t-10">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                <div class="website-traffic-ctn">
                    <h2><span class="counter">50,000</span></h2>
                    <p>Total Website Traffics</p>
                </div>
                <div class="sparkline-bar-stats1"><canvas width="58" height="36" style="display: inline-block; width: 58px; height: 36px; vertical-align: top;"></canvas></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                <div class="website-traffic-ctn">
                    <h2><span class="counter">90,000</span>k</h2>
                    <p>Website Impressions</p>
                </div>
                <div class="sparkline-bar-stats2"><canvas width="58" height="36" style="display: inline-block; width: 58px; height: 36px; vertical-align: top;"></canvas></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30 dk-res-mg-t-30">
                <div class="website-traffic-ctn">
                    <h2>$<span class="counter">40,000</span></h2>
                    <p>Total Online Sales</p>
                </div>
                <div class="sparkline-bar-stats3"><canvas width="58" height="36" style="display: inline-block; width: 58px; height: 36px; vertical-align: top;"></canvas></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30 dk-res-mg-t-30">
                <div class="website-traffic-ctn">
                    <h2><span class="counter">1,000</span></h2>
                    <p>Total Support Tickets</p>
                </div>
                <div class="sparkline-bar-stats4"><canvas width="58" height="36" style="display: inline-block; width: 58px; height: 36px; vertical-align: top;"></canvas></div>
            </div>
        </div>
    </div>
</div>
@endsection