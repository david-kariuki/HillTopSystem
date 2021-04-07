<?php
require_once $_SERVER['DOCUMENT_ROOT']."/app/php/Modal.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();


}

?>
    <div class="content_cover">
        <div class="view_title">
            <h3>Reports</h3>
        </div>
        <div class="items_area reports_area">
            <div class="search_bar">
                <div class="input_search">
                    <input type="search">
                </div>
                <div class="left_icon">

                </div>
            </div>
            <div class="report_button_panel">
                <div class="button_display" onclick="set_report_view('Sales')">
                    <div class="icon_section">
                        <img class="img-thumbnail" src="res/images/icons/sales_reports.png" alt="">
                    </div>
                    <div class="details_section">
                        <p>SALES</p>
                        <p id="content_sales_total">Ksh 5,000.00</p>
                    </div>
                </div>
                <div class="button_display" onclick="set_report_view('Revenue')">
                    <div class="icon_section">
                        <img class="img-thumbnail" src="res/images/icons/revenue_report.png" alt="">
                    </div>
                    <div class="details_section">
                        <p>REVENUE</p>
                        <p id="content_Revenue_total">Ksh 5,000.00</p>
                    </div>
                </div>
                <!-- <div class="button_display" onclick="set_report_view('Orders')">
                    <div class="icon_section">
                        <img class="img-thumbnail" src="res/images/icons/orders_report.png" alt="">
                    </div>
                    <div class="details_section">
                        <p>ORDERS</p>
                        <p id="content_Orders_total">Ksh 5,000.00</p>
                    </div>
                </div> -->
                <!-- <div class="button_display" onclick="set_report_view('Products')">
                    <div class="icon_section">
                        <img class="img-thumbnail" src="res/images/icons/stats.png" alt="">
                    </div>
                    <div class="details_section">
                        <p>Products</p>
                        <p id="content_Products_total">210</p>
                    </div>
                </div> -->
            </div>
            <div class="chart_panel">
                <div class="title_bar">
                    <h4 id="report_title">Chart Title</h4>
                    <div class="export_bar">
                        <div class="elemental_box" onclick="export_content('csv')">
                            <img src="res/images/icons/csv_download.png" alt="">
                        </div>
                        <!-- <div class="elemental_box" onclick="export_content('pdf')">
                            <img src="res/images/icons/pdf_download.png" alt="">
                        </div>
                        <div class="elemental_box" onclick="export_content('view')">
                            <img src="res/images/icons/view_report.png" alt="">
                        </div> -->
                    </div>
                    <div class="calender_picker">
                        <div class="date_picker">
                            <input type="date" class="date-input" name="dateFrom" onchange="range_collector()">
                            <div><img src="res/images/icons/right_arrow.png" alt=""></div>
                            <input type="date" class="date-input" name="dateTo" onchange="range_collector()">
                        </div>
                        <div class="period_picker">
                            <select name="period_picker" id="" onchange="period_collector()">
                                <option value="Month" >This Month</option>
                                <option value="Week">This Week</option>
                                <option value="Day" selected="selected">Today</option>
                                <option value="None">None</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="chart_area">
                    <div class="chart_view" id="bar_chart" style="padding: 10px;">

                    </div>
                    <!-- <div class="chart_control">

                    </div> -->
                </div>
            </div>
            <div class="report_details_panel">
                <div class="report_table_view">
                    <div class="items_area">
                        <table>
                            <thead>
                                <th scope="col">#</th>
                                <th scope="col">Sale ID</th>
                                <th scope="col">Sale type</th>
                                <th scope="col">Sale Amount</th>
                                <th scope="col">Sale Quantity</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <div class="report_stat_view">
                    <h4>Statistics</h4>
                    <div id="piechart">

                    </div>
                </div> -->
            </div>
        </div>
    </div>