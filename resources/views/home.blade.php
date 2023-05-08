<x-ferme-layout>

<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">{{ __('FERME APPS')}}</li>
        <li class="breadcrumb-item active">{{ __('Tableau de bord')}}</li>
    </ol>

    <ul class="app-actions">
        <li>
            <a href="#" id="reportrange">
                <span class="range-text"></span>
                <i class="icon-chevron-down"></i>	
            </a>
        </li>
        <li>
            <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Print">
                <i class="icon-print"></i>
            </a>
        </li>
        <li>
            <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download CSV">
                <i class="icon-cloud_download"></i>
            </a>
        </li>
    </ul>
</div>
<!-- Page header end -->
<div class="content-wrapper fixed-height">

    <!-- Auto vertical scroll start -->
    <div class="fixedBodyScroll">
        
        <div class="content-wrapper-scroll">
        
            <!-- Row starts -->
            <div class="row gutters">
                <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
                    <!-- Row start -->
                    <div class="row gutters">
                        <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="info-tiles">
                                <div class="info-icon">
                                    <i class="icon-account_circle"></i>
                                </div>
                                <div class="stats-detail">
                                    <h3>185k</h3>
                                    <p>Active Users</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="info-tiles">
                                <div class="info-icon">
                                    <i class="icon-watch_later"></i>
                                </div>
                                <div class="stats-detail">
                                    <h3>450</h3>
                                    <p>Active Agents</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="info-tiles">
                                <div class="info-icon">
                                    <i class="icon-visibility"></i>
                                </div>
                                <div class="stats-detail">
                                    <h3>7500</h3>
                                    <p>Visitors</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="info-tiles">
                                <div class="info-icon">
                                    <i class="icon-shopping_basket"></i>
                                </div>
                                <div class="stats-detail">
                                    <h3>$300k</h3>
                                    <p>Sales</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="info-tiles">
                                <div class="info-icon secondary">
                                    <i class="icon-check_circle"></i>
                                </div>
                                <div class="stats-detail">
                                    <h3>250</h3>
                                    <p>Signups</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="info-tiles">
                                <div class="info-icon secondary">
                                    <i class="icon-archive"></i>
                                </div>
                                <div class="stats-detail">
                                    <h3>2500</h3>
                                    <p>Orders</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row ends -->
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card h-280">
                        <div class="card-header">
                            <div class="card-title">Orders</div>
                        </div>
                        <div class="card-body">
                            <div class="chartist bar-scheme-one">
                                <div class="barChartOrders"></div>
                            </div>
                            <div class="row gutters justify-content-center">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="info-stats m-0">
                                        <span class="info-label"></span>
                                        <p class="info-title">Online Orders</p>
                                        <h3 class="info-total">950k</h3>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="info-stats m-0">
                                        <span class="info-label secondary"></span>
                                        <p class="info-title">Direct Orders</p>
                                        <h3 class="info-total">300k</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card h-280 agenda-bg">
                        <div class="card-body">
                            <div class="agenda">
                                <div class="todays-date">
                                    <h5>Agenda - <span class="date" id="todays-date"></span></h5>
                                </div>
                                <ul class="agenda-list">
                                    <li>
                                        <span class="bullet">&nbsp;</span>
                                        <div class="details">
                                            <p>Call with Willams</p>
                                            <small>09:00</small>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="bullet">&nbsp;</span>
                                        <div class="details">
                                            <p>Book a Hotel for James</p>
                                            <small>09:30</small>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="bullet">&nbsp;</span>
                                        <div class="details">
                                            <p>Book a Flight to California</p>
                                            <small>10:00</small>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="bullet secondary">&nbsp;</span>
                                        <div class="details">
                                            <p>Call with Willams</p>
                                            <small>09:00</small>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row end -->
        </div>

    </div>
    <!-- Auto vertical scroll end -->

</div>
</x-ferme-layout>