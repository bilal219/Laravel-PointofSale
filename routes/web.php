<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\uomController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomeraccountController;
use App\Http\Controllers\SupplieraccountController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CombineController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\EmployeeraccountController;
use App\Http\Controllers\whatsapppdfController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
//Employee Account Management
Route::get('/empaccount',[EmployeeraccountController::class,'empaccount'])->name('empaccount'); 
Route::post('/addpayment',[EmployeeraccountController::class,'addpayment'])->name('addpayment');
Route::get('/fetchemppayment',[EmployeeraccountController::class,'fetchemppayment'])->name('fetchemppayment');
Route::post('/withdrawpayment',[EmployeeraccountController::class,'withdrawpayment'])->name('withdrawpayment');
/* Cash Close POS */
 Route::get('poscashregister',[SaleController::class,'poscashregister'])->name('poscashregister');    
/* Password Update */
Route::get('passwords/{id}',[PasswordController::class,'edit'])->name('passwords.edit');
Route::put('updatepassword/{id}',[PasswordController::class,'updatepassword'])->name('passwords.updatepassword');     
/* Barcode */
Route::get('barcode',[BarcodeController::class,'showbarcode'])->name('barcodes.showbarcode');
Route::get('printbarcode', [BarcodeController::class, 'generatebarcode'])->name('barcodes.printbarcode');    
//Combine Account
Route::get('/combines',[CombineController::class,'index'])->name('combines');    
Route::get('/loadcombine',[CombineController::class,'loadcombine'])->name('loadcombine');    
Route::post('/singlecombineaccount',[CombineController::class,'singlecombineaccount'])->name('singlecombineaccount');    
Route::post('/singledatecombineaccount',[CombineController::class,'singledatecombineaccount'])->name('singledatecombineaccount');    
//Company
Route::get('/companies',[CompanyController::class,'index'])->name('companies');
Route::post('/addcomp',[CompanyController::class,'addcomp'])->name('addcomp');
Route::get('/fetchcomp',[CompanyController::class,'fetchcomp'])->name('fetchcomp');
Route::get('/editcomp',[CompanyController::class,'editcomp'])->name('editcomp');
Route::post('/updatecomp',[CompanyController::class,'updatecomp'])->name('updatecomp');
Route::post('/compdelete',[CompanyController::class,'compdelete'])->name('compdelete');
//User 
Route::get('/users',[UserController::class,'index'])->name('users');
Route::post('/adduser',[UserController::class,'adduser'])->name('adduser');
Route::get('/fetchusers',[UserController::class,'fetchusers'])->name('fetchusers');
Route::get('/editusers',[UserController::class,'editusers'])->name('editusers');
Route::put('/updateusers',[UserController::class,'updateusers'])->name('updateusers');
Route::post('/userdelete',[UserController::class,'userdelete'])->name('userdelete');
//hold invoice
Route::post('/holdinvoice',[SaleController::class,'holdinvoice'])->name('holdinvoice');
Route::get('/holdinvoiceslist',[SaleController::class,'holdinvoiceslist'])->name('holdinvoiceslist');
//Expenses
Route::get('/expenses',[ExpenseController::class,'index'])->name('expenses');
Route::post('/addexpense',[ExpenseController::class,'addexpense'])->name('addexpense');
Route::get('/fetchexpenses',[ExpenseController::class,'fetchexpenses'])->name('fetchexpenses');
Route::get('/editexpenses',[ExpenseController::class,'editexpenses'])->name('editexpenses');
Route::put('/updateexpenses',[ExpenseController::class,'updateexpenses'])->name('updateexpenses');
Route::post('/expdelete',[ExpenseController::class,'expdelete'])->name('expdelete');
//Expense Categories
Route::get('/expensecategories',[ExpenseCategoryController::class,'index'])->name('expensecategories');
Route::post('/addexpensecategory',[ExpenseCategoryController::class,'addexpensecategory'])->name('addexpensecategory');
Route::get('/fetchexpensecategories',[ExpenseCategoryController::class,'fetchexpensecategories'])->name('fetchexpensecategories');
Route::get('/editexpensecategory',[ExpenseCategoryController::class,'editexpensecategory'])->name('editexpensecategory');
Route::post('/updateexpensecategory',[ExpenseCategoryController::class,'updateexpensecategory'])->name('updateexpensecategory');
Route::post('/expcatdelete',[ExpenseCategoryController::class,'expcatdelete'])->name('expcatdelete');
//categories Ajax Crud
Route::get('/categories',[CategoriesController::class,'index'])->name('categories');
Route::post('/addcategory',[CategoriesController::class,'addcategory'])->name('addcategory');
Route::get('/fetchcategories',[CategoriesController::class,'fetchcategories'])->name('fetchcategories');
Route::get('/fetchcombocat',[CategoriesController::class,'fetchcombocat'])->name('fetchcombocat');
Route::get('/editcategory',[CategoriesController::class,'editcategory'])->name('editcategory');
Route::post('/updatecategory',[CategoriesController::class,'updatecategory'])->name('updatecategory');
Route::post('/catdelete',[CategoriesController::class,'catdelete'])->name('catdelete');

//areas Ajax Crud
Route::get('/areas',[AreaController::class,'index'])->name('areas');
Route::post('/addarea',[AreaController::class,'addarea'])->name('addarea');
Route::get('/fetchareas',[AreaController::class,'fetchareas'])->name('fetchareas');
Route::get('/editarea',[AreaController::class,'editarea'])->name('editarea');
Route::post('/updatearea',[AreaController::class,'updatearea'])->name('updatearea');
Route::post('/areadelete',[AreaController::class,'areadelete'])->name('areadelete');

//types Ajax Crud
Route::get('/types',[TypeController::class,'index'])->name('types');
Route::post('/addtype',[TypeController::class,'addtype'])->name('addtype');
Route::get('/fetchtypes',[TypeController::class,'fetchtypes'])->name('fetchtypes');
Route::get('/edittype',[TypeController::class,'edittype'])->name('edittype');
Route::post('/updatetype',[TypeController::class,'updatetype'])->name('updatetype');
Route::post('/typedelete',[TypeController::class,'typedelete'])->name('typedelete'); 

//UOM Ajax Crud
Route::get('/uoms',[uomController::class,'index'])->name('uoms');
Route::post('/adduom',[uomController::class,'adduom'])->name('adduom');
Route::get('/fetchuoms',[uomController::class,'fetchuoms'])->name('fetchuoms');
Route::get('/fetchcombouom',[uomController::class,'fetchcombouom'])->name('fetchcombouom');
Route::get('/edituom',[uomController::class,'edituom'])->name('edituom');
Route::post('/updateuom',[uomController::class,'updateuom'])->name('updateuom');
Route::post('/uomdelete',[uomController::class,'uomdelete'])->name('uomdelete');

//employee Ajax Crud
Route::get('/employees',[EmployeeController::class,'index'])->name('employees');
Route::post('/addemployee',[EmployeeController::class,'addemployee'])->name('addemployee');
Route::get('/fetchemployeedata',[EmployeeController::class,'fetchemployeedata'])->name('fetchemployeedata');
Route::get('/editemployee',[EmployeeController::class,'editemployee'])->name('editemployee');
Route::post('/updateemployee',[EmployeeController::class,'updateemployee'])->name('updateemployee');
Route::post('/employeedelete',[EmployeeController::class,'employeedelete'])->name('employeedelete');

//Customer Ajax Crud
Route::get('/customers',[CustomerController::class,'index'])->name('customers');
Route::get('/custlist',[CustomerController::class,'custlist'])->name('custlist');
Route::get('/fetchdropcustomer',[CustomerController::class,'fetchdropcustomer'])->name('fetchdropcustomer');//for dropdown
Route::post('/addcustomer',[CustomerController::class,'addcustomer'])->name('addcustomer');
Route::get('/fetchcustomersdata',[CustomerController::class,'fetchcustomersdata'])->name('fetchcustomersdata');
Route::get('/editcustomer',[CustomerController::class,'editcustomer'])->name('editcustomer');
Route::post('/updatecustomer',[CustomerController::class,'updatecustomer'])->name('updatecustomer');
Route::post('/customerdelete',[CustomerController::class,'customerdelete'])->name('customerdelete');


// fill comboboxes
Route::get('/fetchareadata',[AreaController::class,'fetchareadata'])->name('fetchareadata');
Route::get('/fetchtypedata',[TypeController::class,'fetchtypedata'])->name('fetchtypedata');

//Supplier Ajax Crud
Route::get('/suppliers',[SupplierController::class,'index'])->name('supplierss');
Route::post('/addsupplier',[SupplierController::class,'addsupplier'])->name('addsupplier');
Route::get('/fetchsuppliersdata',[SupplierController::class,'fetchsuppliersdata'])->name('fetchsuppliersdata');
Route::get('/loadsuppliers',[SupplierController::class,'loadsuppliers'])->name('loadsuppliers');
Route::get('/editsupplier',[SupplierController::class,'editsupplier'])->name('editsupplier');
Route::post('/updatesupplier',[SupplierController::class,'updatesupplier'])->name('updatesupplier');
Route::post('/supplierdelete',[SupplierController::class,'supplierdelete'])->name('supplierdelete');

// Product Crud
Route::get('/fetchproductlist',[ProductsController::class,'fetchproducts'])->name('fetchproductlist');
Route::get('/products',[ProductsController::class,'index'])->name('products');
Route::get('/auto_gen_barcode',[ProductsController::class,'auto_gen_barcode'])->name('auto_gen_barcode');
Route::post('/addproducts',[ProductsController::class,'addproduct'])->name('addproducts');
Route::get('/editproduct',[ProductsController::class,'editproduct'])->name('editproduct');
Route::post('/updateproduct',[ProductsController::class,'updateproduct'])->name('updateproduct');
Route::post('/productdelete',[ProductsController::class,'productdelete'])->name('productdelete');
//sale pos
Route::post('/openregister',[SaleController::class,'openregister'])->name('openregister');//open cashregister
Route::get('/cashclose',[SaleController::class,'cashclose'])->name('cashclose');//open cash register
Route::get('/chkclose',[SaleController::class,'chkclose'])->name('chkclose');//check if register is close
Route::post('/closeregister',[SaleController::class,'closeregister'])->name('closeregister');//Close register

//pos
Route::get('/pointofsale',[SaleController::class,'index'])->name('pointofsale');

//load previous balance
Route::get('/loadpreviousbalance',[SaleController::class,'loadpreviousbalance'])->name('loadpreviousbalance');



/* Saleinline */
Route::post('/posinlinechange',[SaleController::class,'posinlinechange'])->name('posinlinechange');
//fetch pos related data
Route::get('/fetchall',[SaleController::class,'fetchall'])->name('fetchall');
    //fetch category wise Products
Route::get('/fetchprods',[SaleController::class,'fetchprods'])->name('fetchprods');
//fetch cust info
Route::get('/fetchcustinfo',[SaleController::class,'fetchcustinfo'])->name('fetchcustinfo');
//fetch proinfo
Route::get('/fetchproinfo',[SaleController::class,'fetchproinfo'])->name('fetchproinfo');
//searching products
Route::get('/searchproducts',[SaleController::class,'searchproducts'])->name('searchproducts');
// cart management
Route::get('/invoice_generator',[SaleController::class,'invoice_generator'])->name('invoice_generator');
Route::post('/addtocart',[SaleController::class,'addtocart'])->name('addtocart');
Route::post('/loadholdinvoice',[SaleController::class,'loadholdinvoice'])->name('loadholdinvoice');
Route::post('/addcartgrid',[SaleController::class,'addcartgrid'])->name('addcartgrid');
Route::get('/loadcart',[SaleController::class,'loadcart'])->name('loadcart');
Route::get('/emptycart',[SaleController::class,'emptycart'])->name('emptycart');
Route::post('/invoiceprint',[SaleController::class,'invoiceprint'])->name('invoiceprint');
Route::get('/removefromcart',[SaleController::class,'removefromcart'])->name('removefromcart');
Route::post('/salecheckout',[SaleController::class,'salecheckout'])->name('salecheckout');
Route::get('/plusincart',[SaleController::class,'plusincart'])->name('plusincart');
Route::get('/minusfromcart',[SaleController::class,'minusfromcart'])->name('minusfromcart');
//autocomplete product textbox
Route::post('/autocomplete',[SaleController::class,'autocomplete'])->name('autocomplete');

// Sale Invoices index page
Route::get('/invoices',[SaleController::class,'invoices'])->name('invoices');
//get invoices
Route::post('/getinvoices',[SaleController::class,'getinvoices'])->name('getinvoices');

// Sales return
Route::get('/salereturn',[SaleController::class,'salereturn'])->name('salereturn');
Route::post('/addtoreturncart',[SaleController::class,'addtoreturncart'])->name('addtoreturncart');
Route::get('/loadreturncart',[SaleController::class,'loadreturncart'])->name('loadreturncart');
Route::get('/removesalereturn',[SaleController::class,'removesalereturn'])->name('removesalereturn');
Route::post('/inlinechange',[SaleController::class,'inlinechange'])->name('inlinechange');
Route::get('/emptyreturncart',[SaleController::class,'emptyreturncart'])->name('emptyreturncart');
Route::get('/salereturninvoice',[SaleController::class,'salereturninvoice'])->name('salereturninvoice');
Route::post('/productreturn',[SaleController::class,'productreturn'])->name('productreturn');

Route::get('/salesreturnlist',[SaleController::class,'salesreturnlist'])->name('salesreturnlist');
Route::post('/getsalereturnlist',[SaleController::class,'getsalereturnlist'])->name('getsalereturnlist');
Route::post('/salereturndetail',[SaleController::class,'salereturndetail'])->name('salereturndetail');

//withinvoice
Route::post('/srinvautocomplete',[SaleController::class,'srinvautocomplete'])->name('srinvautocomplete');
Route::post('/addtoinvoicecart',[SaleController::class,'addtoinvoicecart'])->name('addtoinvoicecart');
Route::get('/loadinvoicereturncart',[SaleController::class,'loadinvoicereturncart'])->name('loadinvoicereturncart');
Route::post('/inlineinvoicechange',[SaleController::class,'inlineinvoicechange'])->name('inlineinvoicechange');
Route::get('/removesaleinvoicereturn',[SaleController::class,'removesaleinvoicereturn'])->name('removesaleinvoicereturn');
Route::get('/emptyinvoicecart',[SaleController::class,'emptyinvoicecart'])->name('emptyinvoicecart');
Route::post('/productinvoicereturn',[SaleController::class,'productinvoicereturn'])->name('productinvoicereturn');



//Stock Mangement

//current stock
Route::get('/currentstock',[ProductsController::class,'currentstock'])->name('currentstock');
Route::post('/loadstock',[ProductsController::class,'loadstock'])->name('loadstock');

//Reorder Products
Route::get('/reorder',[ProductsController::class,'reorder'])->name('reorder');
Route::post('/loadreorder',[ProductsController::class,'loadreorder'])->name('loadreorder');

//Expired Products
Route::get('/expired',[ProductsController::class,'expired'])->name('expired');
Route::post('/loadexpired',[ProductsController::class,'loadexpired'])->name('loadexpired');

//Purcahse
Route::get('/purchase',[PurchaseController::class,'purchase'])->name('purchase');
//purchase cart management
Route::get('/purchaseinvoice',[PurchaseController::class,'purchaseinvoice'])->name('purchaseinvoice');     // generate Invoive
Route::post('/addtopurchasecart',[PurchaseController::class,'addtopurchasecart'])->name('addtopurchasecart');
Route::get('/loadpurchasecart',[PurchaseController::class,'loadpurchasecart'])->name('loadpurchasecart');
Route::get('/removefrompurchasecart',[PurchaseController::class,'removefrompurchasecart'])->name('removefrompurchasecart');
Route::get('/emptypurchasecart',[PurchaseController::class,'emptypurchasecart'])->name('emptypurchasecart');
Route::post('/completepurchase',[PurchaseController::class,'completepurchase'])->name('completepurchase');

//purchaselist
Route::get('/purchaselist',[PurchaseController::class,'purchaselist'])->name('purchaselist');     // generate Invoive
Route::post('/getpurchaseinvoices',[PurchaseController::class,'getpurchaseinvoices'])->name('getpurchaseinvoices');     // generate Invoive

//customer account management
Route::get('/customeraccount',[CustomeraccountController::class,'customeraccount'])->name('customeraccount'); // customer account
Route::post('/singlecustomeraccount',[CustomeraccountController::class,'singlecustomeraccount'])->name('singlecustomeraccount'); // snigle customer account
Route::post('/singledatecustomeraccount',[CustomeraccountController::class,'singledatecustomeraccount'])->name('singledatecustomeraccount'); // snigle customer account
Route::get('/allcustomeraccount',[CustomeraccountController::class,'allcustomeraccount'])->name('allcustomeraccount'); // customer account
Route::get('/customeraddpayview',[CustomeraccountController::class,'customeraddpayview'])->name('customeraddpayview'); // 
Route::post('/addcashpayment',[CustomeraccountController::class,'addcashpayment'])->name('addcashpayment'); // addpayment
Route::post('/addchqpayment',[CustomeraccountController::class,'addchqpayment'])->name('addchqpayment'); // addpayment

//cheque clearance
Route::get('/chqclearanceview',[CustomeraccountController::class,'chqclearanceview'])->name('chqclearanceview'); // customer account
Route::post('/fetchchequeinfo',[CustomeraccountController::class,'fetchchequeinfo'])->name('fetchchequeinfo'); // fetch cheques data
Route::post('/clearcheque',[CustomeraccountController::class,'clearcheque'])->name('clearcheque'); // clear cheque


//Supplier account management
Route::get('/supplieraccount',[SupplieraccountController::class,'supplieraccount'])->name('supplieraccount'); // supplier account
Route::post('/singlesupplieraccount',[SupplieraccountController::class,'singlesupplieraccount'])->name('singlesupplieraccount'); // snigle supplier account
Route::post('/singledatesupplieraccount',[SupplieraccountController::class,'singledatesupplieraccount'])->name('singledatesupplieraccount'); // snigle supplier account
Route::get('/allsupplieraccount',[SupplieraccountController::class,'allsupplieraccount'])->name('allsupplieraccount'); // supplier account
Route::get('/supplieraddpayview',[SupplieraccountController::class,'supplieraddpayview'])->name('supplieraddpayview'); // 
Route::post('/addsuppcashpayment',[SupplieraccountController::class,'addsuppcashpayment'])->name('addsuppcashpayment'); // addpayment
Route::post('/addsuppchqpayment',[SupplieraccountController::class,'addsuppchqpayment'])->name('addsuppchqpayment'); // addpayment

//Suppliercheque clearance
Route::get('/suppchqclearanceview',[SupplieraccountController::class,'suppchqclearanceview'])->name('suppchqclearanceview'); // supplier account
Route::post('/fetchsuppchequeinfo',[SupplieraccountController::class,'fetchsuppchequeinfo'])->name('fetchsuppchequeinfo'); // fetch cheques data
Route::post('/clearsuppcheque',[SupplieraccountController::class,'clearsuppcheque'])->name('clearsuppcheque'); // clear cheque
Route::get('/receivables',[SupplieraccountController::class,'receivables'])->name('receivables'); // clear cheque

// reports

//customer list
Route::get('/company_detail',[ReportController::class,'company_detail'])->name('company_detail');
Route::get('/loadcust_id',[ReportController::class,'loadcust_id'])->name('loadcust_id');
Route::post('/fetchcustList',[CustomerController::class,'fetchcustList'])->name('fetchcustList');

//supplier list
Route::get('/loadsupp_id',[ReportController::class,'loadsupp_id'])->name('loadsupp_id');
Route::get('/suplist',[SupplierController::class,'suplist'])->name('suplist'); //Supplier Report
Route::post('/fetchsuppliers', [SupplierController::class, 'fetchsuppliers'])->name('fetchsuppliers');

//employee list
Route::get('/loademp_id',[ReportController::class,'loademp_id'])->name('loademp_id');
Route::get('/emplist',[EmployeeController::class,'emplist'])->name('emplist'); //Employee Report
Route::post('/fetchemployees', [EmployeeController::class, 'fetchemployees'])->name('fetchemployees');

//Product List
Route::get('/loadcat_id',[ReportController::class,'loadcat_id'])->name('loadcat_id');
Route::get('/productlist',[ReportController::class,'productlist'])->name('productlist'); //Product List Report
Route::post('/fetchproducts', [ReportController::class, 'fetchproducts'])->name('fetchproducts');

// stock movement
Route::get('/stockreport',[ReportController::class,'stockreport'])->name('stockreport'); //Stock  Report
Route::post('/fetchstock', [ReportController::class, 'fetchstock'])->name('fetchstock');

//below order
Route::get('/fetchreorder', [ReportController::class, 'fetchreorder'])->name('fetchreorder');

// Expired products
Route::get('/fetchexpire', [ReportController::class, 'fetchexpire'])->name('fetchexpire');

//customer account
Route::get('/loadcust_acc_id',[ReportController::class,'loadcust_acc_id'])->name('loadcust_acc_id'); //Customer Account  Report
Route::get('/customeraccountreport',[ReportController::class,'customeraccountreport'])->name('customeraccountreport'); //Customer Account  Report
Route::post('/fetchcustaccount', [ReportController::class, 'fetchcustaccount'])->name('fetchcustaccount');
Route::post('/fetchsinglecustaccount', [ReportController::class, 'fetchsinglecustaccount'])->name('fetchsinglecustaccount');

// supplier account report
Route::get('/supplieraccountreport',[ReportController::class,'supplieraccountreport'])->name('supplieraccountreport'); //Supplier Account  Report
Route::post('/fetchsuppaccount', [ReportController::class, 'fetchsuppaccount'])->name('fetchsuppaccount');
Route::post('/fetchsinglesuppaccount', [ReportController::class, 'fetchsinglesuppaccount'])->name('fetchsinglesuppaccount');

// employee account report
Route::get('/empaccountreport',[ReportController::class,'empaccountreport'])->name('empaccountreport'); //Supplier Account  Report
Route::post('/fetchempaccount', [ReportController::class, 'fetchempaccount'])->name('fetchempaccount');
Route::post('/fetchsingleempaccount', [ReportController::class, 'fetchsingleempaccount'])->name('fetchsingleempaccount');

//all user sale
Route::get('/allusersale',[ReportController::class,'allusersale'])->name('allusersale'); //Sales  Report
Route::post('/fetchsales', [ReportController::class, 'fetchsales'])->name('fetchsales');
Route::post('/fetchsaledetails', [ReportController::class, 'fetchsaledetails'])->name('fetchsaledetails');

//single user sale
Route::get('/singleusersale',[ReportController::class,'singleusersale'])->name('singleusersale'); //Sales Detail  Report
Route::post('/fetchsinglesales', [ReportController::class, 'fetchsinglesales'])->name('fetchsinglesales');
Route::post('/fetchsinglesaledetails', [ReportController::class, 'fetchsinglesaledetails'])->name('fetchsinglesaledetails');

//sale return 
Route::get('/salereturnreport',[ReportController::class,'salereturnreport'])->name('salereturnreport'); //Cust Cheques Report
Route::post('/fetchsalereturn',[ReportController::class,'fetchsalereturn'])->name('fetchsalereturn'); //Cust Cheques Report
Route::post('/fetchprodsalereturn',[ReportController::class,'fetchprodsalereturn'])->name('fetchprodsalereturn'); //Cust Cheques Report

//profit loss report
Route::get('/profitlossreport',[ReportController::class,'profitlossreport'])->name('profitlossreport'); //Cust Cheques Report
Route::post('/fetchprofitloss',[ReportController::class,'fetchprofitloss'])->name('fetchprofitloss'); //Cust Cheques Report

//chequelist
Route::get('/chequelistreport',[ReportController::class,'chequelistreport'])->name('chequelistreport'); //Cust Cheques Report
Route::post('/fetchcheques', [ReportController::class, 'fetchcheques'])->name('fetchcheques');
Route::post('/fetchsuppliercheques', [ReportController::class, 'fetchsuppliercheques'])->name('fetchsuppliercheques');

//expense Report
Route::get('/expensereport',[ReportController::class,'expensereport'])->name('expensereport'); //Customer Balances Report
Route::post('/fetchexpense', [ReportController::class, 'fetchexpense'])->name('fetchexpense');
Route::post('/fetchcatexpense', [ReportController::class, 'fetchcatexpense'])->name('fetchcatexpense');

//Business Capital
Route::get('/fetchcapital', [ReportController::class, 'fetchcapital'])->name('fetchcapital');

//customer receivables
Route::get('/customerreceivable',[ReportController::class,'customerreceivable'])->name('customerreceivable'); //All Customer Receivable Report
Route::post('/fetchallreceivale', [ReportController::class, 'fetchallreceivale'])->name('fetchallreceivale');
Route::post('/fetchcustreceivable', [ReportController::class, 'fetchcustreceivable'])->name('fetchcustreceivable');

//customer payables
Route::get('/allpayables',[ReportController::class,'allpayables'])->name('allpayables'); //All Supplier Payables Report
Route::post('/fetchallpayables', [ReportController::class, 'fetchallpayables'])->name('fetchallpayables');
Route::post('/singlepayable',[ReportController::class,'singlepayable'])->name('singlepayable'); //Single Supplier Payables Report

//supplier payables
Route::get('/supp_payables', [ReportController::class, 'supp_payables'])->name('supp_payables');
Route::post('/fetchsupplierpayable', [ReportController::class, 'fetchsupplierpayable'])->name('fetchsupplierpayable');
Route::post('/singlesupplierpayable', [ReportController::class, 'singlesupplierpayable'])->name('singlesupplierpayable');

Route::get('/customerbalance',[ReportController::class,'customerbalance'])->name('customerbalance'); //Customer Balances Report
Route::post('/fetchbalances', [ReportController::class, 'fetchbalances'])->name('fetchbalances');
Route::post('/fetchcustbalances', [ReportController::class, 'fetchcustbalances'])->name('fetchcustbalances');


Route::get('/cashregister',[ReportController::class,'cashregister'])->name('cashregister'); //Customer Balances Report
Route::get('/fetchcashregister', [ReportController::class, 'fetchcashregister'])->name('fetchcashregister');

//Purchase Return without Invoice
Route::get('/purchasereturn',[PurchaseController::class,'purchasereturn'])->name('purchasereturn');
Route::post('/addtopurchreturncart',[PurchaseController::class,'addtopurchreturncart'])->name('addtopurchreturncart');
Route::get('/loadpurchasereturncart',[PurchaseController::class,'loadpurchasereturncart'])->name('loadpurchasereturncart');
Route::get('/removepurchitem',[PurchaseController::class,'removepurchitem'])->name('removepurchitem');
Route::post('/inlinePurchasechange',[PurchaseController::class,'inlinePurchasechange'])->name('inlinePurchasechange');
Route::get('purchasereturninvoice', [PurchaseController::class, 'purchasereturninvoice'])->name('purchasereturninvoice');    
Route::get('/emptypurchasereturncart',[PurchaseController::class,'emptypurchasereturncart'])->name('emptypurchasereturncart');
Route::post('/completepurchasereturn',[PurchaseController::class,'completepurchasereturn'])->name('completepurchasereturn');

//purchase return invoice
Route::post('/prinvautocomplete',[PurchaseController::class,'prinvautocomplete'])->name('prinvautocomplete');
Route::post('/addtopinvoicecart',[PurchaseController::class,'addtopinvoicecart'])->name('addtopinvoicecart');
Route::get('/removepurinvoicereturn',[PurchaseController::class,'removepurinvoicereturn'])->name('removepurinvoicereturn');
Route::get('/loadpinvoicereturncart',[PurchaseController::class,'loadpinvoicereturncart'])->name('loadpinvoicereturncart');
Route::post('/inlinepurinvoicechange',[PurchaseController::class,'inlinepurinvoicechange'])->name('inlinepurinvoicechange');
Route::get('/emptypurchaseinvreturncart',[PurchaseController::class,'emptypurchaseinvreturncart'])->name('emptypurchaseinvreturncart');
Route::post('/purchaseinvoicereturn',[PurchaseController::class,'purchaseinvoicereturn'])->name('purchaseinvoicereturn');

//purchase return list
Route::get('/purchasereturnlist',[PurchaseController::class,'purchasereturnlist'])->name('purchasereturnlist');
Route::post('/getpurchasereturnlist',[PurchaseController::class,'getpurchasereturnlist'])->name('getpurchasereturnlist');
Route::post('/purchasereturndetail',[PurchaseController::class,'purchasereturndetail'])->name('purchasereturndetail');

//unique validations
Route::post('/uniquecustomercnic',[CustomerController::class,'uniquecustomercnic'])->name('uniquecustomercnic');
Route::post('/uniquecustomercontact',[CustomerController::class,'uniquecustomercontact'])->name('uniquecustomercontact');
Route::post('/uniquecat',[CategoriesController::class,'uniquecat'])->name('uniquecat');
Route::post('/uniqueuom',[uomController::class,'uniqueuom'])->name('uniqueuom');

//invoice changes
Route::post('/addinvoicematerial',[SaleController::class,'addinvoicematerial'])->name('addinvoicematerial');
Route::get('/getinvdetail',[SaleController::class,'getinvdetail'])->name('getinvdetail');
Route::get('/delinvlogo',[SaleController::class,'delinvlogo'])->name('delinvlogo');

//whatsapp account message route
Route::post('/whatsappcustaccount',[whatsapppdfController::class,'whatsappcustaccount'])->name('whatsappcustaccount');

});