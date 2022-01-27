<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getReport()
    {
        $genericReport =  DB::select("SELECT 
                                (SELECT FORMAT(IFNULL(COUNT(id) , 0), 0) FROM partner WHERE type ='PROCESSOR' ) total_processor,
                                (SELECT FORMAT(IFNULL(COUNT(id) , 0), 0) FROM aggregator ) total_aggregator,
                                (SELECT FORMAT(IFNULL(COUNT(id) , 0), 0) FROM warehouse WHERE type ='FLOMUVINA' ) total_warehouse ,

                                (SELECT FORMAT(IFNULL(sum(accepted_quantity)/1000 , 0), 0) FROM delivery ) total_volume_fp ,
                                (SELECT FORMAT(IFNULL(sum(quantity)/1000 , 0), 0) FROM warehouse_delivery) total_volume_wh ,
                                (SELECT FORMAT(IFNULL(sum(accepted_quantity * trade_price) , 0), 0) FROM delivery) total_value_fp ,
                                (SELECT FORMAT(IFNULL(sum(quantity * partner_price) , 0), 0) FROM warehouse_delivery) total_value_wh ,
                                (SELECT FORMAT(IFNULL(sum((trade_price - aggregator_price)* accepted_quantity) , 0), 0)  FROM delivery ) total_revenue_fp,
                                (SELECT FORMAT(IFNULL(sum((partner_price - aggregator_price)* quantity) , 0), 0)  FROM warehouse_delivery  ) total_revenue_wh                              
                                ");

        $volumeSummary =  DB::select("
                                SELECT DATE_FORMAT(created_at,'%M') month,month(created_at)mm, ROUND(IFNULL(sum(accepted_quantity)/1000,0),0) volume 
                                FROM delivery group by month(created_at), DATE_FORMAT(created_at,'%M') 
                                order by mm desc
                                    ");

        $valueSummary =  DB::select("
                                SELECT DATE_FORMAT(created_at,'%M') month,month(created_at)mm, 
                                ROUND(IFNULL(sum(accepted_quantity * trade_price )/1000000,0),0) value FROM delivery 
                                group by month(created_at), DATE_FORMAT(created_at,'%M')
                                order by mm desc
                                    ");
                         
        $pieChartReport =  DB::select("
                                SELECT commodity.name commodity, count(dispatch.id) value FROM delivery 
                                INNER JOIN dispatch ON delivery.dispatch_id = dispatch.id 
                                INNER JOIN commodity ON commodity.id = dispatch.commodity_id
                                group by dispatch.commodity_id
                                    ");

        $geoChartReport =  DB::select("
                                SELECT state.name,state.state_code code , count(warehouse.id) value FROM warehouse 
                                INNER JOIN state ON state.id = warehouse.state_id 
                                WHERE type = 'FLOMUVINA'
                                GROUP BY state.name,state.state_code
                                    ");

        $dashboardReport = array(
            'generic' => $genericReport,
            'volumeSummary' => $volumeSummary,
            'valueSummary' => $valueSummary,
            'pieChartReport' => $pieChartReport,
            'geoChartReport' => $geoChartReport,
        );
        return json_encode($dashboardReport);
    }
}
