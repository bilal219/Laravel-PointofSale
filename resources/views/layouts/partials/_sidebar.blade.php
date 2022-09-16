@php
use App\Models\User;
$id = Auth::user()->id;
$pass = User::findorFail($id); 
@endphp
<!-- Sidebar -->
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <!-- <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="../assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{Auth::user()->name ?? ''}}
                            <span class="user-level">{{Auth::User()->email ?? ''}}</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="#profile">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#edit">
                                    <span class="link-collapse">Edit Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#settings">
                                    <span class="link-collapse">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> -->
            <ul class="nav nav-primary">
                <li class="nav-item {{(request()->is('dashboard*')) ? 'active' :''}}">
                    <a  href="{{route('dashboard')}}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        <span class="caret"></span>
                    </a>
                    <!-- <div class="collapse" id="dashboard">
						<ul class="nav nav-collapse">
							<li>
								<a href="../demo1/index.html">
									<span class="sub-item">Dashboard 1</span>
								</a>
							</li>
							<li>
								<a href="../demo2/index.html">
									<span class="sub-item">Dashboard 2</span>
								</a>
							</li>
						</ul>
					</div> -->
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <!-- <h4 class="text-section">Components</h4> -->
                </li>
                <li class="nav-item {{ (request()->is('customers*')) ||  (request()->is('suppliers*')) || (request()->is('employees*'))  ? 'active':''}}">
                    <a data-toggle="collapse" href="#base">
                        <i class="fas fa-user-friends"></i>
                        <p>People</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ (request()->is('customers*')) ||  (request()->is('suppliers*')) || (request()->is('employees*'))  ? 'show':''}}" id="base">
                        <ul class="nav nav-collapse">
                            
                            <li class="{{(request()->is('customers*')) ? 'active' :''}}">
                                <a href="{{route('customers')}}">
                                    <span class="sub-item">Customer</span>
                                </a>
                            </li>
                            <li class="{{(request()->is('suppliers*')) ? 'active' :''}}">
                                <a href="{{route('supplierss')}}">
                                    <span class="sub-item">Suppliers</span>
                                </a>
                            </li>
                            <li class="{{(request()->is('employees*')) ? 'active' :''}}">
                                <a href="{{route('employees')}}">
                                    <span class="sub-item">Employees</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ (request()->is('products*')) ||  (request()->is('categories*')) || (request()->is('uoms*'))  ? 'active':''}}">
                    <a data-toggle="collapse" href="#sidebarLayouts">
                        <i class="fas fa-box-open"></i>
                        <p>Products</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ (request()->is('products*')) ||  (request()->is('categories*')) || (request()->is('uoms*'))  ? 'show':''}}" id="sidebarLayouts">
                        <ul class="nav nav-collapse">
                            <li class="{{(request()->is('products*')) ? 'active' :''}}">
                                <a href="{{route('products')}}">
                                    <span class="sub-item">Products</span>
                                </a>
                            </li>
                            <li class="{{(request()->is('categories*')) ? 'active' :''}}">
                                <a href="{{route('categories')}}">
                                    <span class="sub-item">Categories</span>
                                </a>
                            </li>
                            <li class="{{(request()->is('uoms*')) ? 'active' :''}}">
                                <a href="{{route('uoms')}}">
                                    <span class="sub-item">UOMs</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ (request()->is('currentstock*')) ||  (request()->is('reorder*')) || (request()->is('expired*'))  ? 'active':''}}">
                    <a data-toggle="collapse" href="#stock">
                        <i class="fas fa-boxes"></i>
                        <p>Stock</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ (request()->is('currentstock*')) ||  (request()->is('reorder*')) || (request()->is('expired*'))  ? 'show':''}}" id="stock">
                        <ul class="nav nav-collapse">
                            <li class="{{(request()->is('currentstock*')) ? 'active' :''}}">
                                <a href="{{route('currentstock')}}">
                                    <span class="sub-item">Current Stock</span>
                                </a>
                            </li>
                            <li class="{{(request()->is('reorder*')) ? 'active' :''}}">
                                <a href="{{route('reorder')}}">
                                    <span class="sub-item">Reorder Products</span>
                                </a>
                            </li>
                            <li class="{{(request()->is('expired*')) ? 'active' :''}}">
                                <a href="{{route('expired')}}">
                                    <span class="sub-item">Expire Products</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ (request()->is('pointofsale*')) ||  (request()->is('invoices*')) || (request()->is('salereturn*')) || (request()->is('salesreturnlist*'))  ? 'active':''}}">
                    <a data-toggle="collapse" href="#forms">
                        <i class="fas fa-money-bill-alt"></i>
                        <p>Sales</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ (request()->is('pointofsale*')) ||  (request()->is('invoices*')) || (request()->is('salereturn*')) || (request()->is('salesreturnlist*'))  ? 'show':''}}" id="forms">
                        <ul class="nav nav-collapse">
                            <li class="{{(request()->is('pointofsale*')) ? 'active' :''}}">
                                <a href="{{route('pointofsale')}}" class="pos-reg">
                                    <span class="sub-item">Point Of sale</span>
                                </a>
                            </li>
                            <li class="{{(request()->is('invoices*')) ? 'active' :''}}">
                                <a href="{{route('invoices')}}">
                                    <span class="sub-item">Invoice List</span>
                                </a>
                            </li>
                            <li class="{{(request()->is('salereturn*')) ? 'active' :''}}">
                                <a href="{{route('salereturn')}}">
                                    <span class="sub-item">Sale Return</span>
                                </a>
                            </li>
                            <li class="{{(request()->is('salesreturnlist*')) ? 'active' :''}}">
								<a href="{{route('salesreturnlist')}}">
									<span class="sub-item">Sales Return List</span>
								</a>
							</li>
                            <li>
                                <a href="#" class="cashclose">
                                    <span class="sub-item">Cash Close</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item 
                {{ (request()->is('purchase*')) ||  (request()->is('purchaselist*')) 
                    || (request()->is('purchasereturn*')) || (request()->is('purchasereturnlist*'))
                      ? 'active':''}}">
                    <a data-toggle="collapse" href="#tables">
                        <i class="fas fa-money-check-alt"></i>
                        <p>Purchase</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ (request()->is('purchase*')) ||  (request()->is('purchaselist*')) 
                    || (request()->is('purchasereturn*')) || (request()->is('purchasereturnlist*'))
                      ? 'show':''}}" id="tables">
                        <ul class="nav nav-collapse">
                            <li class="{{(request()->is('purchase*')) ? 'active' :''}}">
                                <a href="{{route('purchase')}}">
                                    <span class="sub-item">Purchase / Add Stock</span>
                                </a>
                            </li>
                            <li class="{{(request()->is('purchaselist*')) ? 'active' :''}}">
                                <a href="{{route('purchaselist')}}">
                                    <span class="sub-item">Purchase Lists</span>
                                </a>
                            </li>
                            <li class="{{(request()->is('purchasereturn*')) ? 'active' :''}}">
                                <a href="{{route('purchasereturn')}}">
                                    <span class="sub-item">Purchase Return</span>
                                </a>
                            </li>
                            <li class="{{(request()->is('purchasereturnlist*')) ? 'active' :''}}">
                                <a href="{{route('purchasereturnlist')}}">
                                    <span class="sub-item">Purchase Return List</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
               <!--  <li class="nav-item">
                    <a data-toggle="collapse" href="#maps1">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <p>Expenses</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="maps1">
                        <ul class="nav nav-collapse">
                           
                        </ul>
                    </div>
                </li> -->
                <li class="nav-item">
                    <a data-toggle="collapse" href="#maps">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <p>Accounts</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="maps">
                        <ul class="nav nav-collapse">
                            <li>
                                <a data-toggle="collapse" href="#custaccount">
                                    <span class="sub-item">Customer</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="custaccount">
                                    <ul class="nav nav-collapse subnav">
                                        <li>
                                            <a href="{{route('customeraccount')}}">
                                                <span class="sub-item">Account</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('customeraddpayview')}}">
                                                <span class="sub-item">Add Payment</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('chqclearanceview')}}">
                                                <span class="sub-item">Cheque Clearace</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#suppaccount">
                                    <span class="sub-item">Supplier</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="suppaccount">
                                    <ul class="nav nav-collapse subnav">
                                        <li>
                                            <a href="{{route('supplieraccount')}}">
                                                <span class="sub-item">Account</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('supplieraddpayview')}}">
                                                <span class="sub-item">Add payment</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('suppchqclearanceview')}}">
                                                <span class="sub-item">Cheque Clearance</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="{{route('empaccount')}}">
                                    <span class="sub-item">Employee</span>
                                </a>
                                <a href="{{route('combines')}}">
                                    <span class="sub-item">Combine</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#submenu">
                        <i class="fas fa-copy"></i>
                        <p>Reports</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="submenu">
                        <ul class="nav nav-collapse">
                            <li>
                                <a data-toggle="collapse" href="#subnav1">
                                    <span class="sub-item">People</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="subnav1">
                                    <ul class="nav nav-collapse subnav">
                                        <li>
                                            <a href="{{route('custlist')}}">
                                                <span class="sub-item">Customer List</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('suplist')}}">
                                                <span class="sub-item">Supplier List</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('emplist')}}">
                                                <span class="sub-item">Employee List</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#subnav2">
                                    <span class="sub-item">Products</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="subnav2">
                                    <ul class="nav nav-collapse subnav">
                                        <li>
                                            <a href="{{route('productlist')}}">
                                                <span class="sub-item">List of Items</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('stockreport')}}">
                                                <span class="sub-item">Purchase/ Return Stock</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" id="blw_order_btn">
                                                <span class="sub-item">Below Reorder Products</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" id="expr_products_btn">
                                                <span class="sub-item">Expire Products</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#subnav3">
                                    <span class="sub-item">Accounts</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="subnav3">
                                    <ul class="nav nav-collapse subnav">
                                        <li>
                                            <a href="{{route('customeraccountreport')}}">
                                                <span class="sub-item">Customer Account</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('supplieraccountreport')}}">
                                                <span class="sub-item">Supplier Account</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('empaccountreport')}}">
                                                <span class="sub-item">Employee Account</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-toggle="collapse" href="#subnav4">
                                    <span class="sub-item">Sales Report</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="subnav4">
                                    <ul class="nav nav-collapse subnav">
                                        <li>
                                            <a href="{{route('allusersale')}}">
                                                <span class="sub-item">All User Sales</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('singleusersale')}}">
                                                <span class="sub-item">Sinlgle User Sales</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('salereturnreport')}}">
                                                <span class="sub-item">Sale Return Report</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="{{route('chequelistreport')}}">
                                    <span class="sub-item">Cheque List</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('profitlossreport')}}">
                                    <span class="sub-item">Profit Loss Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('expensereport')}}">
                                    <span class="sub-item">Expense Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="b_capital">
                                    <span class="sub-item">Business Capital</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('customerreceivable')}}">
                                    <span class="sub-item">Customer Receivables</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('allpayables')}}">
                                    <span class="sub-item">Customer Payables</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('supp_payables')}}">
                                    <span class="sub-item">Supplier Payables</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('customerbalance')}}">
                                    <span class="sub-item">Customer Balances</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('cashregister')}}">
                                    <span class="sub-item">Cash Register</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
				<li class="nav-item">
                    <a data-toggle="collapse" href="#maps2">
                        <i class="fa fa-cog"></i>
                        <p>Configuration</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="maps2">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{route('users')}}">
                                    <span class="sub-item">Manage Users</span>
                                </a>
                            </li>
                            
                            <li>
                               
                               <a href="{{route('expensecategories')}}">
                                   <span class="sub-item">Expense Categories</span>
                               </a>
                               <a href="{{route('expenses')}}">
                                   <span class="sub-item">Manage Expenses</span>
                               </a>
                           </li>
                           <li>
                                <a href="{{route('barcodes.showbarcode')}}">
                                    <span class="sub-item">Print Barcode</span>
                                </a>
                            </li>
                           <li>
                                <a href="{{route('passwords.edit', $pass->id)}}">
                                    <span class="sub-item">Password Reset</span>
                                </a>
                            </li>
                           <li>
                                <a href="{{route('companies')}}">
                                    <span class="sub-item">Bussiness Variables</span>
                                </a>
                            </li>
                           <li>
                                <a href="#" data-toggle="modal" data-target="#invoiceitems" id="btn_sale_inv">
                                    <span class="sub-item">Sale Invoice</span>
                                </a>
                            </li>
                           <li>
                                <a href="#" id="btn_modalchk_inv">
                                    <span class="sub-item">invoice</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- <li class="mx-4 mt-2">
					<a href="http://themekita.com/atlantis-bootstrap-dashboard.html" class="btn btn-primary btn-block"><span class="btn-label mr-2"> <i class="fa fa-heart"></i> </span>Buy Pro</a> 
				</li> -->
            </ul>
        </div>
    </div>
</div>

<!-- End Sidebar -->