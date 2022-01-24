<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li> <a class="waves-effect waves-dark" href="{{ route('dashboard') }}"><i
                            class="icon-speedometer"></i><span class="hide-menu">Dashboard</span></a>
                </li>

                <li> <a class="waves-effect waves-dark" href="{{ route('partner.index') }}"><i
                            class="icon-people"></i><span class="hide-menu">Partners</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{ route('aggregator.index') }}"><i
                            class="icon-people"></i></i><span class="hide-menu">Aggregators</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{ route('trade.index') }}"><i
                            class="fa fa-shopping-cart"></i><span class="hide-menu">Trade</span></a>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
                            class="fas fa-truck"></i><span class="hide-menu">Deliveries</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('dispatch.index') }}"><i class="fas fa-truck"></i> Dispatch</a></li>
                        <li><a href="{{ route('delivery.index') }}"><i class="fas fa-upload"></i> Ticket Upload</a>
                        <li><a href="{{ route('delivery.warehouse.index') }}"><i class="fas fa-upload"></i> Warehouse </a>

                        </li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
                            class="fas fa-bars"></i><span class="hide-menu">Warehouse</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('warehouse.flomuvina.index') }}"><i class="fas fa-bars"></i> Flomuvina</a>
                        </li>
                        <li><a href="{{ route('warehouse.thrive.index') }}"><i class="fas fa-bars"></i> Thrive Agric</a>
                        </li>
                    </ul>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{ route('market.index') }}"><i
                            class="fas fa-bars"></i><span class="hide-menu">Market</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{ route('pricing.index') }}"><i
                            class="fas fa-bars"></i><span class="hide-menu">Pricing</span></a>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
                            class="fas fa-bars"></i><span class="hide-menu">Inventory</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('purchase.index') }}"><i class="fas fa-bars"></i> Purcharse </a></li>
                        <li><a href="{{ route('supply.index') }}"><i class="fas fa-bars"></i> Supply </a></li>
                        <li><a href="#"><i class="fas fa-bars"></i> Stock level </a></li>
                    </ul>
                </li>
                <!-- <li> <a class="waves-effect waves-dark" href="#"><i class="fab fa-amazon-pay"></i><span class="hide-menu">Payment</span></a>
                </li> -->
                <!-- <li> <a class="waves-effect waves-dark" href="#"><i class=" far fa-money-bill-alt"></i><span class="hide-menu">WareHousing</span></a>
                </li> -->
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i
                            class="icon-chart"></i><span class="hide-menu">Reports</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">General Report</a></li>
                        <li><a href="#">Income Report</a></li>
                        <li><a href="#">Expense Report</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
